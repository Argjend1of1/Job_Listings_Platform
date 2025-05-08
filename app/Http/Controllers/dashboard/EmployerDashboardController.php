<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index() {
        return view('employerDashboard.index');
    }

    public function create(Request $request) {

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'jobs' => $user->employer->job
        ]);
    }

    public function edit(Job $job) {
        $job->load('employer');

        if(Auth::user()->id !== $job->employer->user_id) {
            return redirect('/');
        }

        return view('employerDashboard.edit', [
            'job' => $job,
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
            'message' => 'Job updated successfully!',
            'job'     => $job->fresh()->load('tags','employer'),
        ], 200);
//      reloading a fresh model instance for the job with its relations
    }

    public function destroy(Job $job) {
        $job->delete();

        return response()->json([
            'message' => 'Listing deleted successfully!'
        ], 200);
    }
}
