<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $employer = $user->employer;

        return response()->json([
            'user' => $user,
            'employer' => $employer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('account.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'    => 'required|email', // customize as needed
            'employer'      => 'required|string|max:100', // if salary is in string format like "$50,000 USD"
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->employer->update([
            'name' => $request->employer
        ]);

//      send an email to the user through queues

        return response()->json([
            'message' => 'Account updated successfully.',
            'job'     => $user->fresh()->load('employer'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {
        Auth::user()->delete();
        Auth::user()->employer->delete() ?? null;//can be a user only

        return response()->json([
            'message' => 'Account deleted successfully.'
        ], 200);
    }
}
