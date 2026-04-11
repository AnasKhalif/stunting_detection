<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [RoleController::class, 'permissions']);

    // Consultations
    Route::get('consultations', [ConsultationController::class, 'index']);
    Route::post('consultations', [ConsultationController::class, 'store']);
    Route::get('consultations/{id}', [ConsultationController::class, 'show']);
    Route::put('consultations/{id}/status', [ConsultationController::class, 'updateStatus']);
    Route::get('consultations/{id}/messages', [ConsultationController::class, 'messages']);
    Route::post('consultations/{id}/messages', [ConsultationController::class, 'sendMessage']);
});
