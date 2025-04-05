<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()
            ->with(['employer', 'tags'])
            ->get()
            ->groupBy('featured');

//        return $jobs;

        return view('jobs.index', [
            'jobs' => $jobs[0],
            'featuredJobs' => $jobs[1],
            'tags' => Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable']
        ]);

        $attributes['featured'] = $request->has('featured');

        $job = Auth::user()->employer->job()->create(
            Arr::except($attributes, 'tags')
        );


        if($attributes['tags']) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                $job->tag($tag);
            }
        }

        return redirect('/');
    }

    public function edit($id, Job $job) {
        if(Auth::user()->id != $id) {
            return redirect('/');
        }

        return view('dashboard/edit', [
            'job' => $job,
            'id' => $id
        ]);
    }

    public function update(Request $request, $id, Job $job) {

        $request->validate([
            'title'       => 'required|string|max:255',
            'salary'      => 'required|string|max:100', // if salary is in string format like "$50,000 USD"
            'location'    => 'required|string|max:255',
            'schedule'    => 'required|in:Full Time,Part Time', // customize as needed
        ]);

        $job->update([
            'title' => $request->title,
            'salary' => $request->salary,
            'location' => $request->location,
            'schedule' => $request->schedule
        ]);

//      send an email to the user through queues

        return redirect("dashboard/$id");
    }

    public function destroy($id, Job $job) {
        $job->delete();

        return redirect("dashboard/$id");

    }
}
