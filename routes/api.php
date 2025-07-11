<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AutomationController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FloorController;

// ✅ API publique (non protégée pour test)
Route::get('/sites', [SiteController::class, 'index']);
Route::get('/zones', [ZoneController::class, 'index']);
Route::get('/buildings', [BuildingController::class, 'bySite']);
Route::get('/floors', [FloorController::class, 'byBuilding']);

Route::get('/automations', [AutomationController::class, 'index']);
Route::get('/automations/{id}', [AutomationController::class, 'show']);
Route::post('/automations', [AutomationController::class, 'store']);
Route::put('/automations/{id}', [AutomationController::class, 'update']);
Route::delete('/automations/{id}', [AutomationController::class, 'destroy']);
