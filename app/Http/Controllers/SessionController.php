<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            throw ValidationException::withMessages([
                'password' => 'Sorry, those credentials do not match.'
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('login_token')->plainTextToken;
//        dd($token);

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $token
        ]);

//        when it was with sessions and no frontend:
//        $request->session()->regenerateToken();
//        return redirect('/');

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
