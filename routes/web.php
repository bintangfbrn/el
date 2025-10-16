<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\LandingPage\LandingPageController;
use App\Http\Controllers\LandingPage\ServiceController;
use App\Http\Controllers\UserManajemen\PermissionController;
use App\Http\Controllers\UserManajemen\RoleController;
use App\Http\Controllers\UserManajemen\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('index');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::get('/', function () {
        return redirect()->route('index');
    });
});

Route::prefix('/page')->name('landing-page.')->group(function () {
    Route::get('/services', [LandingPageController::class, 'index_services'])->name('index_services');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('/akun')->name('akun.')->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);
    });
    Route::resource('designer', DesignController::class);
    Route::resource('service', ServiceController::class);






    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__ . '/auth.php';
