<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\ZoneV2;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configs = Configuration::with('zones')->get();
        return view('configurations.index', compact('configs'));
    }

    public function create()
    {
        $zones = ZoneV2::all();
        return view('configurations.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'mode' => 'required|string',
            'zones' => 'array',
        ]);

        $config = Configuration::create([
            'name' => $request->name,
            'type' => $request->type,
            'mode' => $request->mode,
        ]);

        if ($request->zones) {
            $config->zones()->sync($request->zones);
        }

        return redirect()->route('configurations.index')->with('success', 'Configuration created!');
    }

    public function edit(Configuration $configuration)
    {
        $zones = ZoneV2::all();
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
        } else {
            $configuration->zones()->detach();
        }

        return redirect()->route('configurations.index')->with('success', 'Configuration updated!');
    }

    public function destroy(Configuration $configuration)
    {
        $configuration->zones()->detach();
        $configuration->delete();
        return redirect()->route('configurations.index')->with('success', 'Configuration deleted!');
    }
}