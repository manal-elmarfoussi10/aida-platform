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

    public function editProfile()
{
    return view('settings.profile', ['user' => auth()->user()]);
}

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'nullable|string|min:6',
    ]);

    $user = auth()->user();
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    return redirect()->route('settings')->with('success', 'Profile updated!');
}

public function editLocation()
{
    return view('settings.location', ['settings' => auth()->user()->settings]);
}

public function updateLocation(Request $request)
{
    $request->validate(['location' => 'required|string']);

    $settings = auth()->user()->settings()->updateOrCreate(
        ['user_id' => auth()->id()],
        ['location' => $request->location]
    );

    return redirect()->route('settings')->with('success', 'Location updated!');
}

public function editLanguage()
{
    return view('settings.language', ['settings' => auth()->user()->settings]);
}

public function updateLanguage(Request $request)
{
    $request->validate(['language' => 'required|string']);

    auth()->user()->settings()->updateOrCreate(
        ['user_id' => auth()->id()],
        ['language' => $request->language]
    );

    return redirect()->route('settings')->with('success', 'Language updated!');
}
}
