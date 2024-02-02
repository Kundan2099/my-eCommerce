<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = "sub_categories";


    static function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('sub_categories.*', 'users.name as created_by_name', 'categories.name as created_name',)
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('users', 'users.id', '=', 'sub_categories.category_id')
            ->orderBy('sub_categories.id', 'desc')
            ->paginate(50);
    }

    static public function getRecordCategory($category_id)
    {
        return self::select('sub_categories.*')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('users', 'users.id', '=', 'sub_categories.category_id')
            ->orderBy('sub_categories.status', '=', 0)
            ->orderBy('sub_categories.category_id', '=', $category_id)
            ->orderBy('sub_categories.', 'asc')
            ->paginate();
    }
}
