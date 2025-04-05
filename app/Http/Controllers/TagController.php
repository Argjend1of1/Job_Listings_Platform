<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __invoke(Tag $tag)
    {
        $search = ($tag['name']);

        return view('results',
            ['jobs' => $tag->jobs, 'search' => $search]
        );
    }
}
