<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AutomationController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ZoneV2Controller;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FloorController;

// Routes API publiques
Route::get('/sites', [SiteController::class, 'index']);
Route::get('/buildings', [BuildingController::class, 'bySite']);
Route::get('/floors', [FloorController::class, 'byBuilding']);
//Route::get('/zones', [ZoneController::class, 'index']);
Route::get('/zones-v2/floor/{floor}/zones', [ZoneV2Controller::class, 'getZones']);
// routes/api.php
Route::get('/zones', fn() => response()->json(['zones' => \App\Models\ZoneV2::all()]));


Route::get('/automations', [AutomationController::class, 'index']); // ?zone=X
Route::get('/automations/{id}', [AutomationController::class, 'show']);
Route::post('/automations', [AutomationController::class, 'store']);
Route::put('/automations/{id}', [AutomationController::class, 'update']);
Route::delete('/automations/{id}', [AutomationController::class, 'destroy']);

Route::get('/test', fn () => response()->json(['ok' => true]));
