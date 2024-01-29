<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Product";
        return view('admin.product.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Add New Product";
        return view('admin.product.add', $data);
    }

    public function insert(Request $request)
    {

        // $validation = Validator::make($request->all(), [
        //     'slug' => ['required', 'string', 'unique:products,slug']
        // ]);

        // if ($validation->fails()) {
        //     return redirect()->back()->withErrors($validation)->withInput();
        // }
        $title = trim($request->title);

        $product = new Product;
        $product->title =$title;
        $product->created_by = Auth::user()->id;
        $product->save();

        $slug = Str::slug($request->input('title'), "-");

       
        if (empty(Product::check()->slug)) {

            $product->slug = $request->input('slug');
            $product->save();
        } else {

            $new_slug = $slug . '-' . $product->id;
            $product->slug = $new_slug;
            $product->save();
        }

        return redirect('admin/product/edit.' . $product->id);
    }

    // public function update(Request $request, $id)
    // {

    //     $product = Product::find($id);

    //     $validation = Validator::make($request->all(), [
    //         'slug' => ['required', 'string', Rule::unique('products')->ignore($product->slug, 'slug')]
    //     ]);

    //     if ($validation->fails()) {
    //         return redirect()->back()->withErrors($validation)->withInput();
    //     }
    // }
}
