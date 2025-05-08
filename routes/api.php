<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\dashboard\EmployerDashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:employer,admin'])->group(function () {
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard', [EmployerDashboardController::class, 'show']);
    Route::patch('/dashboard/edit/{job}', [EmployerDashboardController::class, 'update']);
    Route::delete('/dashboard/edit/{job}', [EmployerDashboardController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {

});

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {

});

Route::middleware([
    'auth:sanctum', 'role:user,employer,admin,superadmin'
])->group(function () {
    Route::get('/user', [SessionController::class, 'index']);
    Route::get('/account', [AccountController::class, 'show']);
    Route::get('/account/edit', [AccountController::class, 'show']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);

    Route::delete('/logout', [SessionController::class, 'destroy']);
});

Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('/login', [SessionController::class, 'store']);
    Route::post('/register', [RegisterController::class, 'store']);
});

