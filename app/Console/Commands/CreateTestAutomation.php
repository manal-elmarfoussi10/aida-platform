<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Automation;
use App\Models\AutomationNode;
use App\Models\AutomationEdge;

class CreateTestAutomation extends Command
{
    protected $signature = 'automation:create-test {zone_id}';
    protected $description = 'Créer une automation de test pour une zone donnée';

    public function handle()
    {
        $zoneId = $this->argument('zone_id');

        $automation = Automation::create([
            'name' => 'Test: Lumières Lobby',
            'zone_id' => $zoneId,
        ]);

        $trigger = AutomationNode::create([
            'automation_id' => $automation->id,
            'type' => 'trigger',
            'data' => ['label' => 'Motion detected in Lobby'],
            'x' => 0,
            'y' => 0,
        ]);

        $condition = AutomationNode::create([
            'automation_id' => $automation->id,
            'type' => 'condition',
            'data' => ['label' => 'After 6pm'],
            'x' => 0,
            'y' => 0,
        ]);

        $action = AutomationNode::create([
            'automation_id' => $automation->id,
            'type' => 'action',
            'data' => ['label' => 'Turn on lights in Lobby'],
            'x' => 0,
            'y' => 0,
        ]);

        AutomationEdge::create([
            'automation_id' => $automation->id,
            'source' => $trigger->id,
            'target' => $condition->id,
        ]);

        AutomationEdge::create([
            'automation_id' => $automation->id,
            'source' => $condition->id,
            'target' => $action->id,
        ]);

        $this->info("Automation test créée avec succès (ID: {$automation->id}) pour zone_id {$zoneId}");
    }
}
