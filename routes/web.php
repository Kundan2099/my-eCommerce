<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Alumni\MembershipContoroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RazorpayController;
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


Route::get('admin', [AuthController::class, 'login_admin'])->name('admin.login');
Route::post('admin', [AuthController::class, 'auth_admin_login'])->name('auth.admin.login');
Route::get('logout/admin', [AuthController::class, 'logout_admin'])->name('admin.logout');



Route::group(['middleware' => 'admin'], function() {

    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/admin/list', [AdminController::class, 'list'])->name('admin.list');
    Route::get('admin/admin/add', [AdminController::class, 'add'])->name('admin.add');
    Route::post('admin/admin/add', [AdminController::class, 'insert'])->name('admin.insert');
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');

    Route::get('admin/category/list', [CategoryController::class, 'list'])->name('admin.category.list');
    Route::get('admin/category/add', [CategoryController::class, 'add'])->name('admin.category.add');
    Route::post('admin/category/add', [CategoryController::class, 'insert'])->name('admin.category.insert');
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('admin/category/edit/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');

    Route::get('admin/sub_category/list', [SubCategoryController::class, 'list'])->name('admin.sub_category.list');
    Route::get('admin/sub_category/add', [SubCategoryController::class, 'add'])->name('admin.sub_category.add');
    Route::post('admin/sub_category/add', [SubCategoryController::class, 'insert'])->name('admin.sub_category.insert');
    Route::get('admin/sub_category/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.sub_category.edit');
    Route::post('admin/sub_category/edit/{id}', [SubCategoryController::class, 'update'])->name('admin.sub_category.update');
    Route::get('admin/sub_category/delete/{id}', [SubCategoryController::class, 'delete'])->name('admin.sub_category.delete');


    Route::post('admin/get_sub_category', [SubCategoryController::class, 'get_sub_category']);


    Route::get('admin/brand/list', [BrandController::class, 'list'])->name('admin.brand.list');
    Route::get('admin/brand/add', [BrandController::class, 'add'])->name('admin.brand.add');
    Route::post('admin/brand/add', [BrandController::class, 'insert'])->name('admin.brand.insert');
    Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
    Route::post('admin/brand/edit/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
    Route::get('admin/brand/delete/{id}', [BrandController::class, 'delete'])->name('admin.brand.delete');

    Route::get('admin/color/list', [ColorController::class, 'list'])->name('admin.color.list');
    Route::get('admin/color/add', [ColorController::class, 'add'])->name('admin.color.add');
    Route::post('admin/color/add', [ColorController::class, 'insert'])->name('admin.color.insert');
    Route::get('admin/color/edit/{id}', [ColorController::class, 'edit'])->name('admin.color.edit');
    Route::post('admin/color/edit/{id}', [ColorController::class, 'update'])->name('admin.color.update');
    Route::get('admin/color/delete/{id}', [ColorController::class, 'delete'])->name('admin.color.delete');

    Route::get('admin/product/list', [ProductController::class, 'list'])->name('admin.product.list');
    Route::get('admin/product/add', [ProductController::class, 'add'])->name('admin.product.add');
    Route::post('admin/product/add', [ProductController::class, 'insert'])->name('admin.product.insert');
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('admin/product/edit/{id}', [BrandController::class, 'update'])->name('admin.product.update');    
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');

    Route::prefix('coupon')->controller(CouponController::class)->group(function () {
        Route::get('/', 'viewCouponList')->name('admin.view.coupon.list');
        Route::get('/create', 'viewCouponCreate')->name('admin.view.coupon.create');
        Route::get('/update/{id}', 'viewCouponUpdate')->name('admin.view.coupon.update');
        Route::post('/create', 'handleCouponCreate')->name('admin.handle.coupon.create');
        Route::post('/update/{id}', 'handleCouponUpdate')->name('admin.handle.coupon.update');
        Route::put('/status', 'handleToggleCouponStatus')->name('admin.handle.coupon.status');
        Route::get('/delete/{id}', 'handleCouponDelete')->name('admin.handle.coupon.delete');
    });

    Route::prefix('membership')->controller(MembershipContoroller::class)->group(function () {
        Route::get('/', 'viewMembershipList')->name('admin.view.membership.list');
        Route::get('/create', 'viewMembershipCreate')->name('admin.view.membership.create');
        Route::get('/update/{id}', 'viewMembershipUpdate')->name('admin.view.membership.update');
        Route::post('/create', 'handleMembershipCreate')->name('admin.handle.membership.create');
        Route::post('/update/{id}', 'handleMembershipUpdate')->name('admin.handle.membership.update');
        Route::put('/status', 'handleToggleMembershipStatus')->name('admin.handle.membership.status');
        Route::get('/delete/{id}', 'handleMembershipDelete')->name('admin.handle.membership.delete');
    });

    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::get('/', 'viewServiceList')->name('admin.view.service.list');
        Route::get('/create', 'viewServiceCreate')->name('admin.view.service.create');
        Route::get('/update/{id}', 'viewServiceUpdate')->name('admin.view.service.update');
        Route::post('/create', 'handleServiceCreate')->name('admin.handle.service.create');
        Route::post('/update/{id}', 'handleServiceUpdate')->name('admin.handle.service.update');
        Route::put('/status', 'handleToggleServiceStatus')->name('admin.handle.service.status');
        Route::get('/delete/{id}', 'handleServiceDelete')->name('admin.handle.service.delete');
    });

    Route::prefix('check')->controller(ServiceController::class)->group(function () {
        Route::get('/', 'viewCheckList')->name('admin.view.check.list');
        Route::get('/create', 'viewCheckCreate')->name('admin.view.check.create');
        Route::get('/update/{id}', 'viewCheckUpdate')->name('admin.view.check.update');
        Route::post('/create', 'handleCheckCreate')->name('admin.handle.check.create');
        Route::post('/update/{id}', 'handleCheckUpdate')->name('admin.handle.check.update');
        Route::put('/status', 'handleToggleCheckStatus')->name('admin.handle.check.status');
        Route::get('/delete/{id}', 'handleCheckDelete')->name('admin.handle.check.delete');
    });

    Route::prefix('uplode')->controller(ServiceController::class)->group(function () {
        Route::get('/', 'viewUplodeList')->name('admin.view.uplode.list');
        Route::get('/create', 'viewUplodeCreate')->name('admin.view.uplode.create');
        Route::get('/update/{id}', 'viewUplodeUpdate')->name('admin.view.uplode.update');
        Route::post('/create', 'handleUplodeCreate')->name('admin.handle.uplode.create');
        Route::post('/update/{id}', 'handleUplodeUpdate')->name('admin.handle.uplode.update');
        Route::put('/status', 'handleToggleUplodeStatus')->name('admin.handle.uplode.status');
        Route::get('/delete/{id}', 'handleUplodeDelete')->name('admin.handle.uplode.delete');
    });

});

Route::get('product',[RazorpayController::class,'index']);
Route::post('razorpay-payment',[RazorpayController::class,'store'])->name('razorpay.payment.store');