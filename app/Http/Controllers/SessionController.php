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
        $tags = Auth::user()->tags;


        return response()->json([
            'user' => $user,
            'employer' => $employer,
            'tags' => $tags
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
        $attributes = $request->validated();

        if(! Auth::attempt($attributes)) {
            return throw ValidationException::withMessages([
                'password' => 'Sorry, those credentials do not match.'
            ]);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $user->createToken('GeneratedTokens')->plainTextToken
        ]);
    }


    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }

    public function dashboard($id) {
        if(Auth::user()->id != $id) {
            return redirect('/');
        }

        $user = User::find($id);

        return view('dashboard/index', [
            'user' => $user
        ]);
    }
}
