<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function list() {

        $getRecord = Color::all();
        $data['header_title'] = "Color";
        return view('admin.color.list', ['getRecord' => $getRecord], $data);
    }


    public function add() {

        $data['header_title'] = "Add Color";
        return view('admin.color.add', $data);
    }


    public function insert(Request $request) {
        
        $color = new Color;
        $color->name = $request->input('name');
        $color->code = $request->input('code');
        $color->status = $request->input('status');
        $color->created_by = Auth::user()->id;
        $color->save();

        return redirect()->route('admin.color.list')->with('success', "Color Successfully Created");
    }


    public function edit($id) {
        $color = Color::find($id);
        $data['header_title'] = "Add Color";
        return view('admin.color.edit', ['color' => $color], $data);
    }


    public function update(Request $request,$id) {

        $color = Color::find($id);
        $color->name = $request->input('name');
        $color->code = $request->input('code');
        $color->status = $request->input('status');
        $color->created_by = Auth::user()->name;
        $color->update();

        return redirect()->route('admin.color.list')->with('success', "Color Successfully Created");
    }

    public function delete($id) {
        $color = Color::find($id);
        $result = $color->delete();

        if ($result) {
            return redirect()->route('admin.color.list')->with('success', "Color Successfully Deleted");
        }
    }


}
