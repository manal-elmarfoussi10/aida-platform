<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Automation;
use App\Models\ZoneV2;

class AutomationController extends Controller
{
    /**
     * Liste des automatisations par zone (résumé avec label des nœuds)
     */
    public function index(Request $request)
    {
        $zoneId = $request->query('zone');

        $query = Automation::with(['nodes', 'edges'])
            ->when($zoneId, fn($q) => $q->where('zonev2_id', $zoneId));

        $automations = $query->get()->map(function ($automation) {
            $trigger = $automation->nodes->firstWhere('type', 'trigger');
            $condition = $automation->nodes->firstWhere('type', 'condition');
            $action = $automation->nodes->firstWhere('type', 'action');

            return [
                'id' => $automation->id,
                'name' => $automation->name,
                'trigger' => $trigger?->data['label'] ?? null,
                'condition' => $condition?->data['label'] ?? null,
                'action' => $action?->data['label'] ?? null,
            ];
        });

        return response()->json(['automations' => $automations]);
    }

    /**
     * Crée une nouvelle automation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zonev2_id' => 'required|exists:zones_v2,id',
            'nodes' => 'required|array',
            'edges' => 'required|array',
        ]);
    
        $automation = Automation::create([
            'name' => $validated['name'],
            'zonev2_id' => $validated['zonev2_id'],
        ]);
    
        // Save nodes
        foreach ($validated['nodes'] as $node) {
            $automation->nodes()->create([
                'type' => $node['data']['type'] ?? 'custom',
                'data' => $node['data'],
                'x' => $node['position']['x'] ?? 0,
                'y' => $node['position']['y'] ?? 0,
            ]);
        }
    
        // Save edges
        foreach ($validated['edges'] as $edge) {
            $automation->edges()->create([
                'source_node_id' => $edge['source'],
                'target_node_id' => $edge['target'],
            ]);
        }
    
        return response()->json([
            'message' => 'Automation created with nodes and edges.',
            'automation' => $automation
        ]);
    }

    /**
     * Affiche les détails d’une automation (pour FlowEditor.vue)
     */
    public function show($id)
    {
        $automation = Automation::with(['nodes', 'edges'])->findOrFail($id);

        return response()->json([
            'id' => $automation->id,
            'name' => $automation->name,
            'nodes' => $automation->nodes->map(fn ($node) => [
                'id' => $node->id,
                'type' => $node->type,
                'data' => $node->data,
                'x' => $node->x,
                'y' => $node->y,
            ]),
            // Correct :
'edges' => $automation->edges->map(function ($edge) {
    return [
        'id' => $edge->id,
        'source' => (string) $edge->source_node_id,
        'target' => (string) $edge->target_node_id,
    ];
}),

        ]);
    }

    /**
     * Met à jour une automation
     */
    public function update(Request $request, $id)
    {
        $automation = Automation::findOrFail($id);
        $automation->update($request->only(['name', 'zonev2_id']));

        return response()->json([
            'message' => 'Automation updated successfully',
            'automation' => $automation
        ]);
    }

    /**
     * Supprime une automation
     */
    public function destroy($id)
    {
        $automation = Automation::findOrFail($id);
        $automation->delete();

        return response()->json([
            'message' => 'Automation deleted successfully'
        ]);
    }

    /**
     * Vue Blade pour éditeur
     */
    public function editor()
    {
        $zones = ZoneV2::all();
        return view('automations.editor', compact('zones'));
    }

    /**
     * Vue pour la création d'une automation
     */
    public function create()
    {
        return view('automations.create');
    }

    /**
     * Automatisations pour une zone donnée
     */
    public function byZone($zoneId)
    {
        $automations = Automation::where('zonev2_id', $zoneId)->get();
        return response()->json(['automations' => $automations]);
    }
}
