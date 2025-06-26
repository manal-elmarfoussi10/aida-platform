<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboards.admin', [
            'comfortScore' => 82,
            'energyUsage' => 1.2,
            'issues' => 2,
            'alerts' => ['⚠️ Zone too hot', '🔧 Maintenance needed']
        ]);
    }

    public function facility()
    {
        return view('dashboards.facility', [
            'comfortScore' => 76,
            'energyUsage' => 1.8,
            'issues' => 1,
            'alerts' => ['🔧 Maintenance due in Zone B']
        ]);
    }

    public function user()
    {
        return view('dashboards.user', [
            'comfortScore' => 91,
            'energyUsage' => 0.7,
            'issues' => 0,
            'alerts' => []
        ]);
    }
}
