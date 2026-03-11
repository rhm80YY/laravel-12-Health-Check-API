<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HealthCheckController;

Route::prefix('v1')->group(function () {
    Route::get('/status', [HealthCheckController::class, 'status']);
    Route::get('/ping', [HealthCheckController::class, 'ping']);
    Route::post('/echo', [HealthCheckController::class, 'echo']);
});