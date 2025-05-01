<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index');
    }

    public function create(Request $request) {
//      will only work if route protected with auth:sanctum and a valid token is sent with the request
//      laravel automatically checks for the authenticated user.
        $user = $request->user();

        return response()->json([
            'user' => $user,
            'jobs' => $user->employer->job
        ]);
    }

    public function edit(Job $job) {
        return view('dashboard/edit', [
            'job' => $job,
        ]);
    }

    public function editJob(Job $job) {
        $user = Auth::user();

        return response()->json([
            'employer' => $user->employer,
            'job' => $job
        ]);
    }

    public function update(Request $request, Job $job) {

        $request->validate([
            'title'       => 'required|string|max:255',
            'schedule'    => 'required|in:Full Time,Part Time', // customize as needed
            'salary'      => 'required|string|max:100', // if salary is in string format like "$50,000 USD"
        ]);

        $job->update([
            'title' => $request->title,
            'schedule' => $request->schedule,
            'salary' => $request->salary
        ]);

//      send an email to the user through queues

        return response()->json([
            'message' => 'Job updated successfully.',
            'job'     => $job->fresh()->load('tags','employer'),
        ], 200);
//      reloading a fresh model instance for the job with its relations
    }
}
