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
    public function index(Request $request)
    {
        $jobs = Job::latest()
            ->with(['employer', 'tags'])
            ->get()
            ->groupBy('featured');

//        dd($jobs->first()[0]->load('employer'));
//        dd($jobs->first());

//        return $jobs;
        return view('index', [
            'jobs' => $jobs->first() ?? null,
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

        $attributes['category_id'] = Auth::user()->employer->category_id;

        $job = Auth::user()->employer->job()->create(
            Arr::except($attributes, 'tags')
        );

        if($attributes['tags']) {
            foreach (explode(',', strtolower($attributes['tags'])) as $tag) {
                $job->tag($tag);
            }
        }

        $job->load('employer');
        $job->load('tags');

        return response()->json([
            'message' => "Job Listed Successfully!",
            'jobs' => $job
        ]);
    }

    public function show() {
        $jobs = Job::latest()
            ->with(['employer', 'tags'])
            ->get()
            ->groupBy('featured');

//        dd($jobs->first()[0]->load('employer'));
//        dd($jobs->first());

//        return $jobs;
        return view('jobs.index', [
            'jobs' => $jobs->first() ?? null,
            'tags' => Tag::all()
        ]);
    }
}
