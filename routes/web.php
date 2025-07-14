<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    ZoneController,
    DeviceController,
    ScheduleController,
    FloorplanController,
    RoomController,
    ZoneV2Controller,
    ConfigurationController,
    ZoneMappingController,
    ControlController,
    AssistantController,
    API\AutomationController,
    SettingsController,
    AIReportAssistantController,
    ReportController,
    SiteController,
    BuildingController,
    FloorController,
    NetworkDeviceController,
    LegacyUserController
};

// Redirect root to login
Route::get('/', fn() => redirect()->route('login'));

// Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard by role
Route::middleware(['auth', 'role:Admin'])->get('/admin', [DashboardController::class, 'admin']);
Route::middleware(['auth', 'role:Facility Manager'])->get('/facility', [DashboardController::class, 'facility']);
Route::middleware(['auth', 'role:User'])->get('/user', [DashboardController::class, 'user']);

Route::get('/dashboard', fn() => redirect(\App\Providers\RouteServiceProvider::redirectTo()))->middleware('auth')->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
// Zones V2
Route::prefix('zones-v2')->name('zones-v2.')->middleware('auth')->group(function () {
    Route::get('/', [ZoneV2Controller::class, 'index'])->name('index');
    Route::get('/create', [ZoneV2Controller::class, 'create'])->name('create');
    Route::post('/', [ZoneV2Controller::class, 'store'])->name('store');
    Route::get('/{zone}/edit', [ZoneV2Controller::class, 'edit'])->name('edit');
    Route::put('/{zone}', [ZoneV2Controller::class, 'update'])->name('update');
    Route::delete('/{zone}', [ZoneV2Controller::class, 'destroy'])->name('destroy');
    Route::post('/{zone}/toggle', [ZoneV2Controller::class, 'toggleStatus'])->name('toggle');
    Route::post('/import', [ZoneV2Controller::class, 'import'])->name('import');
});

// Dynamic filters for Site > Building > Floor > Zone (used in config/devices/etc.)
Route::middleware(['auth'])->group(function () {
    Route::get('/zones-v2/site/{site}/buildings', [ZoneV2Controller::class, 'getBuildings']);
    Route::get('/zones-v2/building/{building}/floors', [ZoneV2Controller::class, 'getFloors']);
    Route::get('/zones-v2/floor/{floor}/zones', [ZoneV2Controller::class, 'getZones']);
});

// Devices
Route::middleware(['auth'])->group(function () {
    Route::resource('devices', DeviceController::class);
    Route::post('devices/{device}/toggle-status', [DeviceController::class, 'toggleStatus'])->name('devices.toggleStatus');
    Route::post('devices/{device}/toggle-manual', [DeviceController::class, 'toggleManual'])->name('devices.toggleManual');
    Route::post('/devices/import', [DeviceController::class, 'import'])->name('devices.import');
});

// Schedules
Route::middleware(['auth'])->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/events', [ScheduleController::class, 'events'])->name('schedules.events');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
});

// Floorplan
Route::middleware(['auth'])->group(function () {
    Route::get('/floorplan', [RoomController::class, 'index'])->name('floorplan');
    Route::get('/floorplan/create', [RoomController::class, 'create'])->name('floorplan.create');
    Route::post('/floorplan/store', [RoomController::class, 'store'])->name('floorplan.store');
    Route::post('/floorplan/{room}/toggle-light', [RoomController::class, 'toggleLight'])->name('floorplan.toggleLight');
    Route::post('/floorplan/{room}/toggle-shade', [RoomController::class, 'toggleShade'])->name('floorplan.toggleShade');
});

// Configurations
Route::middleware(['auth'])->group(function () {
    Route::resource('configurations', ConfigurationController::class);
    Route::get('/get-buildings/{siteId}', [ConfigurationController::class, 'getBuildings']);
    Route::get('/get-floors/{buildingId}', [ConfigurationController::class, 'getFloors']);
    Route::get('/get-zones/{floorId}', [ConfigurationController::class, 'getZones']);
});

// Zone mapping
Route::middleware(['auth'])->group(function () {
    Route::get('/zone-mapping', [ZoneMappingController::class, 'index'])->name('map-zones.index');
    Route::post('/zone-mapping/update', [ZoneMappingController::class, 'update'])->name('map-zones.update');
    Route::get('/zone-mapping/export', [ZoneMappingController::class, 'export'])->name('map-zones.export');
});

// Assistants
Route::middleware(['auth'])->group(function () {
    Route::get('/assistants/chat', [AssistantController::class, 'chatView'])->name('assistants.chat');
    Route::post('/assistants/send', [AssistantController::class, 'sendMessage'])->name('assistants.send');
});

// Control
Route::middleware(['auth'])->group(function () {
    Route::get('/controls', [ControlController::class, 'index'])->name('controls.index');
    Route::get('/controls/{id}', [ControlController::class, 'show'])->name('controls.show');
    Route::post('/controls/update/{id}', [ControlController::class, 'update'])->name('controls.update');
    // Show controls page with optional filters
Route::get('/controls/{device?}', [ControlController::class, 'index'])->name('controls.index');

// Update a specific device
Route::post('/controls/update/{id}', [ControlController::class, 'update'])->name('controls.update');
});

// Automations
Route::middleware(['auth'])->group(function () {
    Route::get('/automations', [AutomationController::class, 'editor'])->name('automations');
Route::post('/automations', [AutomationController::class, 'store'])->name('automations.store');
Route::get('/automations/{id}/graph', [AutomationController::class, 'graph']);

Route::get('/automations/create', function () {
    return view('automations.create');
})->name('automations.create');

});

// Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/profile', [SettingsController::class, 'editProfile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile']);
    Route::get('/settings/location', [SettingsController::class, 'editLocation'])->name('settings.location');
    Route::post('/settings/location', [SettingsController::class, 'updateLocation']);
    Route::get('/settings/language', [SettingsController::class, 'editLanguage'])->name('settings.language');
    Route::post('/settings/language', [SettingsController::class, 'updateLanguage']);
});

// Reports
Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/ai/reports/respond', [AIReportAssistantController::class, 'respond'])->name('ai.reports.respond');
});

// Network devices
Route::middleware(['auth'])->group(function () {
    Route::get('/network-devices', [NetworkDeviceController::class, 'index'])->name('network.index');
    Route::post('/network-devices/{id}/toggle', [NetworkDeviceController::class, 'toggle'])->name('network.toggle');
    Route::post('/network/scan', [NetworkDeviceController::class, 'scan'])->name('network.scan');
});

// Sites
Route::middleware(['auth'])->group(function () {


    Route::get('/sites', [SiteController::class, 'index'])->name('sites.index');
    Route::get('/sites/create', [SiteController::class, 'create'])->name('sites.create');
    Route::post('/sites', [SiteController::class, 'store'])->name('sites.store');
    Route::get('/sites/{site}/edit', [SiteController::class, 'edit'])->name('sites.edit'); // ✅ MISSING
    Route::put('/sites/{site}', [SiteController::class, 'update'])->name('sites.update'); // ✅ MISSING
    Route::delete('/sites/{site}', [SiteController::class, 'destroy'])->name('sites.destroy'); // ✅ MISSING
});

// Floors
Route::middleware(['auth'])->group(function () {
    Route::resource('floors', FloorController::class);
});

// Buildings
Route::middleware(['auth'])->group(function () {
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
    Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
    Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
    Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');
    Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy');
});

// Hierarchy
Route::middleware(['auth'])->group(function () {
    Route::get('/hierarchy', [\App\Http\Controllers\HierarchyController::class, 'index'])->name('hierarchy.index');
});


//test nmap
Route::get('/test-nmap', function () {
    $output = shell_exec('which nmap && nmap -sn 127.0.0.1/24');
    return nl2br($output ?? 'Nothing returned');
});

use App\Models\ZoneV2;

Route::get('/automations/create', function () {
    $zones = ZoneV2::select('id', 'name')->get(); // Récupérer toutes les zones
    return view('automations.create', compact('zones')); // Passer les zones à la vue
})->name('automations.create');


// Auth routes
require __DIR__.'/auth.php';
