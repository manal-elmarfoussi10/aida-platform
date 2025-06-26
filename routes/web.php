<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
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

require __DIR__.'/auth.php';

