<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke()
    {
        $search = request('q');
        $jobs = Job::with(['employer', 'tags'])
            ->where('title', 'LIKE', '%'.$search.'%')
            ->get();

        return view('results', ['jobs' => $jobs, 'search' => $search]);

        //look for tags also
    }
}
