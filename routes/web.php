<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FloorplanController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\ZoneV2Controller;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ZoneMappingController;
use App\Http\Controllers\ControlController;
use App\Http\Livewire\ControlToggle;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\API\AutomationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AIReportAssistantController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FloorController;

use App\Http\Controllers\NetworkDeviceController;



// Redirection page d'accueil
Route::get('/', function () {
    return redirect()->route('login');
});

// Gestion du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboards selon rôles
Route::middleware(['auth', 'role:Admin'])->get('/admin', [DashboardController::class, 'admin']);
Route::middleware(['auth', 'role:Facility Manager'])->get('/facility', [DashboardController::class, 'facility']);
Route::middleware(['auth', 'role:User'])->get('/user', [DashboardController::class, 'user']);

// Redirection dashboard
Route::get('/dashboard', function () {
    return redirect(\App\Providers\RouteServiceProvider::redirectTo());
})->middleware('auth')->name('dashboard');

// Zones
// oute::middleware(['auth'])->group(function () {
 //   Route::resource('zones', ZoneController::class);
 //   Route::post('/zones/{zone}/toggle-control', [ZoneController::class, 'toggleControl']);
// });

//zone version 2
Route::prefix('zones-v2')->name('zones-v2.')->group(function () {
    Route::get('/', [ZoneV2Controller::class, 'index'])->name('index');
    Route::get('/create', [ZoneV2Controller::class, 'create'])->name('create');
    Route::post('/', [ZoneV2Controller::class, 'store'])->name('store');
    Route::get('/{zone}/edit', [ZoneV2Controller::class, 'edit'])->name('edit');
    Route::put('/{zone}', [ZoneV2Controller::class, 'update'])->name('update');
    Route::delete('/{zone}', [ZoneV2Controller::class, 'destroy'])->name('destroy');
    Route::post('/{zone}/toggle', [ZoneV2Controller::class, 'toggleStatus'])->name('toggle');
    Route::post('/zones-v2/{zone}/toggle', [ZoneV2Controller::class, 'toggle'])->name('zones-v2.toggle');
    Route::post('/import', [ZoneV2Controller::class, 'import'])->name('import');
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

    Route::middleware(['auth'])->group(function () {
    Route::resource('configurations', ConfigurationController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/zone-mapping', [ZoneMappingController::class, 'index'])->name('map-zones.index');
Route::post('/zone-mapping/update', [ZoneMappingController::class, 'update'])->name('map-zones.update');
Route::get('/zone-mapping/export', [ZoneMappingController::class, 'export'])->name('map-zones.export');

});



Route::middleware(['auth'])->group(function () {
    Route::get('/assistants/chat', [AssistantController::class, 'chatView'])->name('assistants.chat');
    Route::post('/assistants/send', [AssistantController::class, 'sendMessage'])->name('assistants.send');

});

});

// controller
Route::middleware(['auth'])->group(function () {
    Route::get('/controls', [ControlController::class, 'index'])->name('controls.index');
Route::get('/controls/{id}', [ControlController::class, 'show'])->name('controls.show');
Route::post('/controls/update/{id}', [ControlController::class, 'update'])->name('controls.update');
});

//automation Route::get('/automations/editor', function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/automations', [AutomationController::class, 'editor'])->name('automations');
    });

    //settings

    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        Route::get('/settings/profile', [SettingsController::class, 'editProfile'])->name('settings.profile');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile']);

        Route::get('/settings/location', [SettingsController::class, 'editLocation'])->name('settings.location');
        Route::post('/settings/location', [SettingsController::class, 'updateLocation']);

        Route::get('/settings/language', [SettingsController::class, 'editLanguage'])->name('settings.language');
        Route::post('/settings/language', [SettingsController::class, 'updateLanguage']);
    });

//reports
Route::middleware(['auth'])->group(function () {

    // Reports & AI Assistant
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/ai/reports/respond', [AIReportAssistantController::class, 'respond'])->name('ai.reports.respond');

    // Logout handled by Laravel's built-in auth scaffolding
});
//NetworkDevice

Route::middleware(['auth'])->group(function () {
    Route::get('/network-devices', [NetworkDeviceController::class, 'index'])->name('network.index');
    Route::post('/network-devices/{id}/toggle', [NetworkDeviceController::class, 'toggle'])->name('network.toggle');
    Route::post('/network/scan', [NetworkDeviceController::class, 'scan'])->name('network.scan');
});


//sites
Route::middleware(['auth'])->group(function () {

    // 🔹 SITES
    Route::get('/sites', [SiteController::class, 'index'])->name('sites.index');
    Route::get('/sites/create', [SiteController::class, 'create'])->name('sites.create');
    Route::post('/sites', [SiteController::class, 'store'])->name('sites.store');
    Route::get('/sites/{site}', [SiteController::class, 'show'])->name('sites.show');

    



});


//
//floors
Route::middleware(['auth'])->group(function () {
    Route::resource('floors', FloorController::class);
});


//buildings
Route::middleware(['auth'])->group(function () {
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
    Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
    Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
    Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');
    Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy');
});


//hierarchy
Route::middleware(['auth'])->group(function () {
    Route::get('/hierarchy', [App\Http\Controllers\HierarchyController::class, 'index'])->name('hierarchy.index');
});


// Auth routes
require __DIR__.'/auth.php';
