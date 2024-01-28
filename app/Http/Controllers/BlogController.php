<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function list()
    {
        try {
            $blog = Blog::all();
            return view('blog.list', ['blog' => $blog]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }


    public function add()
    {
        try {
            return view('blog.add');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    public function insert(Request $request)
    {

        try {
            $validation = Validator::make($request->all(), [
                'title' => ['required', 'string'],
                'summary' => ['required', 'string'],
                'description' => ['required', 'string'],
                'thumbnail_image' => ['required', 'file', 'mimes:jpg,png,webp,jpeg'],
                'meta_description' => ['required', 'string'],
                'meta_titl' => ['required', 'string'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $blog = new Blog();
            $blog->title = $request->input('title');
            $blog->summary = $request->input('summary');
            $blog->description = $request->input('description');
            $blog->thumbnail = $request->file('thumbnail')->store('blogs');
            $blog->meta_description = $request->input('meta_description');
            $blog->meta_titl = $request->input('meta_titl');
            $blog->save();

            return redirect()->route('blog.list')->with(
                'message',
                'Blog Successfully Added'
            );
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    public function edit($id)
    {

        try {
            $blog = Blog::find($id);
            return view('blog.edit', ['blog' => $blog]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::find($id);

            if (is_null($blog)) {
                return abort(404);
            }

            $validation = Validator::make($request->all(), [
                'title' => ['required', 'string'],
                'summary' => ['required', 'string'],
                'description' => ['required', 'string'],
                'thumbnail_image' => ['required', 'file', 'mimes:jpg,png,webp,jpeg'],
                'meta_description' => ['required', 'string'],
                'meta_titl' => ['required', 'string'],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $blog->title = $request->input('title');
            $blog->summary = $request->input('summary');
            $blog->description = $request->input('description');
            $blog->thumbnail = $request->file('thumbnail')->store('Blog');
            $blog->meta_description = $request->input('meta_description');
            $blog->meta_titl = $request->input('meta_title');
            $blog->update();

            return redirect()->route('blog.list')->with(
                'message',
                'Blog Successfully Added'
            );
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }


    public function delete($id)
    {

        try {
            $blog = Blog::find($id);

            $blog->delete();
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }
}
