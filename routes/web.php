<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboard\EmployerDashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/edit', [AccountController::class, 'edit']);
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::get('/dashboard', [EmployerDashboardController::class, 'index']);
    Route::get('/dashboard/edit/{job}', [EmployerDashboardController::class, 'edit']);
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisterController::class, 'create']);
});

Route::get('/employers', [EmployerController::class, 'index']);
Route::get('/employer/{id}/jobs', [EmployerController::class, 'show']);

Route::get('/categories/{name}', [CategoryController::class, 'index']);

Route::get('/search', [SearchController::class, '__invoke']);
Route::get('/tags/{tag:name}', [TagController::class, '__invoke']);//{tag:name} - frontend
Route::get('/jobs', [JobController::class, 'index']);



