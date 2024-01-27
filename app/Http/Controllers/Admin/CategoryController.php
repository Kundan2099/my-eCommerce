<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list() {
        $getCategory = Category::all();
        $data['header_title'] = "Category";
        return view('admin.category.list', $data, ['getCategory' => $getCategory], $data);
    }

    public function add() {
        $data['header_title'] = "Add Category";
        return view('admin.category.add', $data);
    }

    public function insert(Request $request) {

        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:categories']
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $category = new Category;
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->created_by = Auth::user()->name;
        $category->save();

        return redirect()->route('admin.category.list')->with('success', "Category Successfully Created");
    }

    public function edit($id) {
        $getCategory = Category::find($id);
        $data['header_title'] = "Edit Category";
        return view('admin.category.edit', ['getCategory' => $getCategory], $data);
    }

    public function update(Request $request, $id) {


        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:categories,slug,'.$id]
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->created_by = Auth::user()->name;
        $category->update();

        return redirect()->route('admin.category.list')->with('success', "Category Successfully Update");

    }

    public function delete($id) {

        $getCategory = Category::find($id);
        $result = $getCategory->delete();

        if ($result) {
            return redirect()->route('admin.category.list')->with('message', 'Product Successfully Delete');
        }


    }
}

