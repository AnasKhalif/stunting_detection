<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FoodRecommendationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StuntingController;
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
    // Users & Roles
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [RoleController::class, 'permissions']);

    // Profile
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('profile/change-password', [ProfileController::class, 'changePassword']);

    // Dashboard
    Route::get('dashboard/parent', [DashboardController::class, 'parent']);
    Route::get('dashboard/doctor', [DashboardController::class, 'doctor']);
    Route::get('dashboard/admin', [DashboardController::class, 'admin']);

    // Children
    Route::apiResource('children', ChildController::class);

    // Stunting Detection
    Route::post('stunting/detect', [StuntingController::class, 'detect']);
    Route::get('stunting/history', [StuntingController::class, 'history']);
    Route::get('stunting/history/{id}', [StuntingController::class, 'show']);

    // Food Recommendations
    Route::get('foods', [FoodRecommendationController::class, 'index']);
    Route::get('foods/by-status', [FoodRecommendationController::class, 'byStatus']);
    Route::get('foods/{id}', [FoodRecommendationController::class, 'show']);

    // Consultations
    Route::get('consultations', [ConsultationController::class, 'index']);
    Route::post('consultations', [ConsultationController::class, 'store']);
    Route::get('consultations/{id}', [ConsultationController::class, 'show']);
    Route::put('consultations/{id}/status', [ConsultationController::class, 'updateStatus']);
    Route::get('consultations/{id}/messages', [ConsultationController::class, 'messages']);
    Route::post('consultations/{id}/messages', [ConsultationController::class, 'sendMessage']);
});
