<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validation = Validator::make($request->all(), [
            'id' => ['required', 'string'],
            'title' => ['required', 'string', 'min:1', 'max:250'],
            'description' => ['required', 'string', 'min:1', 'max:250'],
            'summary' => ['required', 'string', 'min:1', 'max:250'],
            'skills' => ['required', 'string', 'min:1', 'max:250'],
            'salary' => ['required', 'string', 'min:1', 'max:250'],
            'location' => ['required', 'string'],
            'emoloment_type' => ['required', 'string'],
            'documents' => ['required', 'file', ],
            'apply_url' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }



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