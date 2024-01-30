<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function list()
    {
        $getRecord = Brand::all();
        $data['header_title'] = "Brand";
        return view('admin.brand.list', ['getRecord' => $getRecord], $data);
    }


    public function add() {
        $data['header_title'] = "Add Brand";
        return view('admin.brand.add', $data);
    }


    public function insert(Request $request) {

        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:brands']
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $brand = new Brand;
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->status = $request->input('status');
        $brand->meta_title = $request->input('meta_title');
        $brand->meta_description = $request->input('meta_description');
        $brand->meta_keyword = $request->input('meta_keyword');
        $brand->created_by = Auth::user()->name;
        $brand->save();

        return redirect()->route('admin.brand.list')->with('success', "Brand Successfully Created");
    }


    public function edit($id) {
        $brand = Brand::find($id);
        $data['header_title'] = "Edit Brand";
        return view('admin.brand.edit', ['brand' => $brand], $data);
    }


    public function update(Request $request, $id) {

        $validation = Validator::make($request->all(), [
            'slug' => ['required', 'unique:brands,slug,'.$id]
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $brand = Brand::find($id);
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->status = $request->input('status');
        $brand->meta_title = $request->input('meta_title');
        $brand->meta_description = $request->input('meta_description');
        $brand->meta_keyword = $request->input('meta_keyword');
        $brand->created_by = Auth::user()->name;
        $brand->update();

        return redirect()->route('admin.brand.list')->with('success', "Brand Successfully Update");

    }

    public function delete($id) {

        $getBrand = Brand::find($id);
        $result = $getBrand->delete();

        if ($result) {
            return redirect()->route('admin.brand.list')->with('message', 'Brand Successfully Delete');
        }


    }
}
