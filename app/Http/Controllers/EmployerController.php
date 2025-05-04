<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index()
    {
        $employers = Employer::latest()
//            ->with('job') //if needed
            ->simplePaginate(10);

//        dd($employers);

        return view('employer.employers', [
            'employers' => $employers
        ]);
    }

    public function show($id)
    {
        $employer = Employer::with('job')->findOrFail($id);
        $jobs = $employer->job->all();

//        create blade:
        return view('employer.employerListedJobs', [
            'employer' => $employer,
            'jobs' => $jobs
        ]);
    }
}
