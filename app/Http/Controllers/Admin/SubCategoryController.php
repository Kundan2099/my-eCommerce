<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function list() {
        $getRecord = SubCategory::all();
        $data['header_title'] = "Sub Category";
        return view('admin.sub_category.list',['getRecord' => $getRecord], $data);
    }

    public function add() {
        $category = Category::all();
        $data['header_title'] = "Add Sub Category";
        return view('admin.sub_category.add',['category' => $category], $data);
    }

    public function insert(Request $request) {

        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:sub_categories']
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $subcategory = new SubCategory;
        $subcategory->category_id = $request->input('category_id');
        $subcategory->name = $request->input('name');
        $subcategory->slug = $request->input('slug');
        $subcategory->status = $request->input('status');
        $subcategory->meta_title = $request->input('meta_title');
        $subcategory->meta_description = $request->input('meta_description');
        $subcategory->meta_keyword = $request->input('meta_keyword');
        $subcategory->created_by = Auth::user()->id;
        $subcategory->save();

        return redirect()->route('admin.sub_category.list')->with('success', "Sub Category Successfully Created");
    }


    public function edit($id) {
        $category = Category::all();
        $getCategory = SubCategory::find($id);
        $data['header_title'] = "Edit Sub Category";
        return view('admin.sub_category.edit', ['getCategory' => $getCategory],['category' => $category], $data);
    }

    public function update(Request $request, $id) {

        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:sub_categories,slug,'.$id]
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $subcategory = SubCategory::find($id);
        $subcategory->category_id = $request->input('category_id');
        $subcategory->name = $request->input('name');
        $subcategory->slug = $request->input('slug');
        $subcategory->status = $request->input('status');
        $subcategory->meta_title = $request->input('meta_title');
        $subcategory->meta_description = $request->input('meta_description');
        $subcategory->meta_keyword = $request->input('meta_keyword');
        $subcategory->created_by = Auth::user()->id;
        $subcategory->save();

        return redirect()->route('admin.sub_category.list')->with('success', "Sub Category Successfully Update");

    }

    public function delete($id) {

        $getCategory = SubCategory::find($id);

        $result = $getCategory->delete();

        if ($result) {

            return redirect()->route('admin.sub_category.list')->with('message', ' Sub Category Successfully Delete');
        }
    }

}
