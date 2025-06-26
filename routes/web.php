<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:Admin'])->get('/admin', [DashboardController::class, 'admin']);
Route::middleware(['auth', 'role:Facility Manager'])->get('/facility', [DashboardController::class, 'facility']);
Route::middleware(['auth', 'role:User'])->get('/user', [DashboardController::class, 'user']);

Route::get('/dashboard', function () {
    return redirect(\App\Providers\RouteServiceProvider::redirectTo());
})->middleware('auth')->name('dashboard');

//route for zone
Route::middleware(['auth'])->group(function () {
    Route::resource('zones', ZoneController::class);
});

//device
Route::middleware(['auth'])->group(function () {
    Route::resource('devices', DeviceController::class);

    Route::post('devices/{device}/toggle-status', [DeviceController::class, 'toggleStatus'])->name('devices.toggleStatus');
    Route::post('devices/{device}/toggle-manual', [DeviceController::class, 'toggleManual'])->name('devices.toggleManual');
});
require __DIR__.'/auth.php';

