<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with('buildings')->get();
        return view('sites.index', compact('sites'));
    }

    public function show(Site $site)
    {
        $site->load('buildings.floors'); // load buildings + floors
        return view('sites.show', compact('site'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Site created successfully.');
    }
}
