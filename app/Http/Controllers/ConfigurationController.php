<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        // Charger les zones liées
        $configs = Configuration::with('zones')->get();

        // Envoyer à la vue
        return view('configurations.index', compact('configs'));
    }

    public function create()
    {
        // Tu peux récupérer les zones pour un formulaire de sélection
        $zones = \App\Models\Zone::all();
        return view('configurations.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'mode' => 'required|string',
            'zones' => 'array', // facultatif
        ]);

        $config = Configuration::create([
            'name' => $request->name,
            'type' => $request->type,
            'mode' => $request->mode,
        ]);

        // Associer les zones
        if ($request->zones) {
            $config->zones()->sync($request->zones);
        }

        return redirect()->route('configurations.index')->with('success', 'Configuration created!');
    }

    public function edit(Configuration $configuration)
    {
        $zones = \App\Models\Zone::all();
        return view('configurations.edit', compact('configuration', 'zones'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'mode' => 'required|string',
            'zones' => 'array',
        ]);

        $configuration->update($request->only(['name', 'type', 'mode']));

        if ($request->zones) {
            $configuration->zones()->sync($request->zones);
        }

        return redirect()->route('configurations.index')->with('success', 'Configuration updated!');
    }

    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        return redirect()->route('configurations.index')->with('success', 'Configuration deleted!');
    }
}
