<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list() {
        $data['header_title'] = "Product";
        return view('admin.product.list',$data);
    }

    public function add() {
        $data['header_title'] = "Add New Product";
        return view('admin.product.add', $data);
    }

    public function insert(Request $request) {

        $title = trim($request->title);
        $product = new Category;
        $product->title = $title;
        $product->created_by = Auth::user()->id;
        $product->save();

        $slug = Str::slug($title, "-");

        $checkSlug = Category::check($slug);
        if (empty($checkSlug)) {

            $product->slug = $slug;
            $product->save();
        } else {

           $new_slug = $slug.'-'.$product->id;
           $product->slug = $new_slug;
           $product->save();
        }

        return redirect('admin.product.edit.' .$product->id);
    }
    
}

