<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\dashboard\EmployerDashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/', function(Request $request) {
//    return response()->json([
//        'user' => $request->user(),
//        'jobs' => Job::latest()->with(['employer','tags'])->get(),
//        'tags' => Tag::all(),
//    ]);
//});

//Route::get('/', [JobController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:employer,admin'])->group(function () {
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard', [EmployerDashboardController::class, 'index']);
    Route::get('/user/jobs', [EmployerDashboardController::class, 'create']);
    Route::get('/dashboard/edit/{job}', [EmployerDashboardController::class, 'editJob']);
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
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

