<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        $data['header_title'] = "Product";
        return view('admin.product.list', ['products' => $products], $data);
    }

    public function add()
    {
        $data['header_title'] = "Add New Product";
        return view('admin.product.add', $data);
    }

    public function insert(Request $request)
    {
        try {

            $product = new Product;
            $product->title = $request->input('title');
            $product->created_by = Auth::user()->name;
            $product->save();

            $slug = Str::slug($request->input('title'), "-");

            $checkSlug = Product::find($slug);
            if (empty($checkSlug)) {
                $product->slug = $slug;
                $product->save();
            }
            $new_sulg = $slug . '-' . $product->id;
            $product->slug = $new_sulg;
            $product->save();

            return redirect('admin/product/edit/' . $product->id);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }


    public function edit($id)
    {
        try {
            $product = Product::find($id);
            if (!empty($product)) {
                $categorys = Category::all();
                
                $data['product'] = $product;
                $data['header_title'] = "Edit Product";
                return view('admin.product.edit',['categorys' => $categorys], $data);
            }
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
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->status = $request->input('status');
        $category->meta_title = $request->input('meta_title');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->created_by = Auth::user()->name;
        $category->update();

        return redirect()->route('admin.product.list')->with('success', "Product Successfully Update");
    }

    public function delete($id)
    {

        $getCategory = Product::find($id);
        $result = $getCategory->delete();

        if ($result) {
            return redirect()->route('admin.product.list')->with('message', 'Product Successfully Delete');
        }
    }
}
