<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $tabl = "categories";

   
    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('categories.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'categories.created_by')
            ->orderBy('categories.id', 'desc')
            ->get();
    }

    static public function getRecordActive()
    {
        return self::select('categories.*', 'users.name as created_by_name')
            ->join('users', 'users_id', '=', 'categories.created_by')
            ->where('categories.status', '=', 'desc')
            ->ordereBy('categories.id', 'asc')
            ->get();
    }
}
