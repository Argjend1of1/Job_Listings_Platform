<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index']);

Route::get('/search', [SearchController::class, '__invoke']);
Route::get('/tags/{tag:name}', [TagController::class, '__invoke']);//{tag:name} - frontend

Route::middleware('auth')->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::post('/jobs', [JobController::class, 'store']);
    Route::delete('/logout', [SessionController::class, 'destroy']);
    Route::get('/dashboard/{id}', [SessionController::class, 'dashboard']);
    Route::get('/dashboard/{id}/edit/{job}', [JobController::class, 'edit']);
    Route::patch('/dashboard/{id}/edit/{job}', [JobController::class, 'update']);
    Route::delete('/dashboard/{id}/edit/{job}', [JobController::class, 'destroy']);
});


Route::middleware('guest')->group(function () {
//    Route::get('/register', [RegisteredUserController::class, 'create']);
//    Route::post('/register', [RegisteredUserController::class, 'store']);

//    Route::get('/login', [SessionController::class, 'create'])->name('login');
//    Route::post('/login', [SessionController::class, 'store']);
});




