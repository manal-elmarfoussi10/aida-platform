<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\API\AutomationController;

Route::get('/schedules', [ScheduleApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/zones', [ZoneController::class, 'index']);
    Route::get('/automations/{zone}', [AutomationController::class, 'show']);
    Route::post('/automations/{zone}', [AutomationController::class, 'store']);
});