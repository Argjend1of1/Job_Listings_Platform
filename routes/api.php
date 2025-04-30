<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


//Route::middleware('auth:sanctum')->get('/', function(Request $request) {
//    return response()->json([
//        'user' => $request->user(),
//        'jobs' => Job::latest()->with(['employer','tags'])->get(),
//        'tags' => Tag::all(),
//    ]);
//});

//Route::get('/', [JobController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [SessionController::class, 'dashboard']);
    Route::get('/user/jobs', [SessionController::class, 'listJobs']);
    Route::get('/user', [SessionController::class, 'index']);
    Route::get('/jobs/create', [JobController::class, 'create']);
});


Route::middleware(['web', 'guest:sanctum'])->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

