<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboards.admin');
    }

    public function facility()
    {
        return view('dashboards.facility');
    }

    public function user()
    {
        return view('dashboards.user');
    }
}
