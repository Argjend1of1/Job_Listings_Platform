<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        $employers = Employer::whereHas('user', function ($userQuery) use ($query) {
            $userQuery->where('role', 'employer');

            if ($query) {
                $userQuery->where('name', 'like', "%{$query}%");
            }
        })
            ->latest()
            ->simplePaginate(10)
            ->appends(['q' => $query]);

        return view('adminEmployer.employers', [
            'employers' => $employers,
            'query' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // You can now use $id to find and delete the employer
        $employer = Employer::findOrFail($id);
        $user = $employer->user;

        $employer->job()->delete();
        $user->delete();
        $employer->delete();

        return response()->json(['message' => 'Employer deleted successfully']);
    }
}
