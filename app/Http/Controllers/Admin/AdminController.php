<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function list() {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = "Admin";
        return view('admin.admin.list', $data);
    }

    public function add() {
        $data['header_title'] = "Add New Admin";
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request) {

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->is_admin = 1;
        $user->save();

        return redirect()->route('admin.list')->with('success', 'Admin Successfully Created');

    }

    // public function edit($id) {
    //     $user = User::find($id);

    //     if (is_null($user)) {
    //         return abort(404);
    //     }

    //     return view('product-update', ['user' => $user]);
    // }


    public function edit($id) {

        $data['getRecord'] = User::getSingle($id);
        
        $data['header_title'] = "Edit Admin";
        return view('admin.admin.edit', $data);
    }

    public function update(Request $request,$id) {

        $user = User::getSingle($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->is_admin = 1;
        $user->update();

        return redirect()->route('admin.list')->with('Update', 'Admin Successfully Update');

    }

    public function delete($id) {

        
    }

}