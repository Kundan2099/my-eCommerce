<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // static public function products()
    // {
    //     return self::select('products.*', 'users.name as created_by_name')
    //         ->join('users', 'users.id', '=', 'products.created_by')
    //         ->orderBy('products.id', 'desc')
    //         ->paginate(50);
    // }

    // static public function checkSlug($slug) {
    //     return self::where('slug', '=', $slug)->count();
    // }


}
