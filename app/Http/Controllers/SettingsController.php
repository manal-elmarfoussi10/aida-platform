<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserSetting;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $settings = $user->settings ?? new UserSetting([
            'location' => 'New York City, NY, USA',
            'language' => 'EN',
            'notifications' => true,
            'dark_mode' => false,
        ]);
    
        return view('settings.index', [
            'settings' => $settings,
            'version' => '8.2.12'
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'location' => 'required|string',
            'language' => 'required|string'
        ]);
    
        $user = auth()->user();
    
        // Update user email
        $user->email = $request->input('email');
        $user->save();
    
        // Update or create user settings
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'location' => $request->input('location'),
                'language' => $request->input('language'),
            ]
        );
    
        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
