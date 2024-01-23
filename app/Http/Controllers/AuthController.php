<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login_admin() {
        
        if (!empty(Auth::check()) && Auth::user()->is_admin == 1) {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }

    public function auth_admin_login(Request $request) {
      
        $remember = !empty($request->remember) ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
            return redirect('admin/dashboard');
        } else{

            return redirect()->back()->with('error', 'please enter currect email and password');
        }

    }

    public function logout_admin() {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
