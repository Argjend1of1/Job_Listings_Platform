<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($categoryName) {
        $category = Category::where('name', $categoryName)->first();
        $jobs = $category->job;
//        foreach ($jobs as $job) {
//            dd($job->employer);
//        }

        return view('categories.category', [
            'jobs' => $jobs,
            'category' => $category
        ]);
    }
}
