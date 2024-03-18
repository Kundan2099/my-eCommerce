<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class JobPostController extends Controller 
{
    // Index method to display all job posts
    public function list()
    {
        $jobPosts = JobPost::all();
        return view('job-post-list', compact('jobPost'));
    }

    // Method to show the form for creating a new job post
    public function create()
    {
        return view('job-post-create');
    }

    // Method to store a newly created job post in the database
    public function store(Request $request)
    {
        $request->validate([
            'id' =>'required',
            'title' => 'required',
            'description' => 'required',
            'summary' =>'required',
            'skills' =>'required',
            'salary' =>'required',
            'location' =>'required',
            'emoloment_type' =>'required',
            'documents' =>'required',
            'apply_url' =>'required',
            'status' =>'required',
            
            // Add more validation rules as needed
        ]);

        JobPost::create($request->all());

        return redirect()->route('job-post-list')
            ->with('success', 'Job post created successfully.');
    }

    
    // Method to update the specified job post in the database
    public function update(Request $request, JobPost $jobPost)
    {
        $request->validate([
            'id' =>'required',
            'title' => 'required',
            'description' => 'required',
            'summary' =>'required',
            'skills' =>'required',
            'salary' =>'required',
            'location' =>'required',
            'emoloment_type' =>'required',
            'documents' =>'required',
            'apply_url' =>'required',
            'status' =>'required',
            
        ]);

        $jobPost->update($request->all());

        return redirect()->route('job-post-list')
            ->with('success', 'Job post updated successfully');
    }

    
}