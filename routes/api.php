<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->get('/user', [SessionController::class, 'index']);

Route::get('/login', [SessionController::class, 'create'])
    ->name('login');

Route::post('/login', [SessionController::class, 'store']);
