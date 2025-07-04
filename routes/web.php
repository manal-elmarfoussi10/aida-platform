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
<<<<<<< HEAD
use App\Http\Controllers\ControlController;
use App\Http\Livewire\ControlToggle;
=======
use App\Http\Controllers\AssistantController;





>>>>>>> ad80d21dd059a0414a06e5ebc84d1d6e0b917348

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


// Auth routes
require __DIR__.'/auth.php';
