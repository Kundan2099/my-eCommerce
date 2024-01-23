<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', [AuthController::class, 'login_admin'])->name('admin.login');
Route::post('admin', [AuthController::class, 'auth_admin_login'])->name('auth.admin.login');

Route::get('logout/admin', [AuthController::class, 'logout_admin'])->name('admin.logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/admin/list', function () {
    return view('admin.admin.list');
});