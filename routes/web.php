<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\FaqController;


Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [LandingController::class, 'indexAbout'])->name('about');
Route::get('/artikel', [LandingController::class, 'indexArtikel'])->name('artikel');
Route::get('/artikel/{id}', [LandingController::class, 'show'])->name('artikel.show');
Route::get('/kalkulator', [KalkulatorController::class, 'create'])->name('kalkulator.create');
Route::post('/kalkulator', [KalkulatorController::class, 'store'])->name('kalkulator.store');


Route::name('admin.')->prefix('admin')->namespace('App\Http\Controllers\Admin')->middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('user', 'UserController');
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
});

Route::resource('status', StatusController::class)->middleware('auth');
Route::resource('article', ArticleController::class)->middleware('auth');
Route::resource('faq', FaqController::class)->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');
});

Route::get('/api/province/{id}/cities', function ($id) {
    $cities = City::where('province_id', $id)->pluck('name', 'id');
    return response()->json($cities);
});


require __DIR__ . '/auth.php';
