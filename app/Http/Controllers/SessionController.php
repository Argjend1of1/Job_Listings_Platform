<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class SessionController extends Controller
{/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $employer = Auth::user()->employer;

        return response()->json([
            'user' => $user,
            'employer' => $employer,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }


    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => Auth::user()
        ]);
    }


    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }

    public function dashboard() {
        return view('dashboard.index');
    }

    public function listJobs(Request $request) {
//      will only work if route protected with auth:sanctum and a valid token is sent with the request
//      laravel automatically checks for the authenticated user.
        $user = $request->user();

        return response()->json([
            'user' => $user,
            'jobs' => $user->employer->job
        ]);
    }
}
