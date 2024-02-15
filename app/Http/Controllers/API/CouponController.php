<?php

namespace App\Http\Controllers\API;

use App\Enums\CouponDiscountType;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $coupons = Coupon::all();

            return response([
                'status' => true,
                'message' => "Coupons successfully fetched",
                'data' => $coupons
            ], 200);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "Internal server error. Please try again",
                'errors' => $exception
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $coupons = Coupon::find($id);

            return response([
                'status' => true,
                'message' => "Coupons successfully fetched",
                'data' => $coupons
            ], 200);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "Internal server error. Please try again",
                'errors' => $exception
            ], 500);
        }
    }


    public static function checkCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->get();

        if ($coupon->isEmpty()) {

      
                return response([
                    'status' => true,
                    'message' => $message->
                    'data' => $coupon
                ], 200);
        
            $response = ['valid' => false, 'message' => 'Coupon code not recognised'];
        } elseif (isset($coupon->end_date) && $coupon->end_date < Carbon::now()) {
            $response = ['valid' => false, 'message' => 'Sorry, that coupon has expired.'];
        } elseif (isset($coupon->start_date) && $coupon->start_date > Carbon::now()) {
            $response = ['valid' => false, 'message' => 'Sorry, that coupon is not yet valid.'];
        } elseif (isset($coupon->status) && $coupon->status === 'inactive') {
            $response = ['valid' => false, 'message' => 'Sorry, that coupon is inactive.'];
        } else {
            $response = ['valid' => true, 'message' => 'Coupon applied successfully!.'];
        }

        return ($response);
    }
}

      
return response([
    'status' => true,
    'message' => $message->
    'data' => $coupon
], 200);

$response = ['valid' => false, 'message' => 'Coupon code not recognised'];
} elseif (isset($coupon->end_date) && $coupon->end_date < Carbon::now()) {
$response = ['valid' => false, 'message' => 'Sorry, that coupon has expired.'];
} elseif (isset($coupon->start_date) && $coupon->start_date > Carbon::now()) {
$response = ['valid' => false, 'message' => 'Sorry, that coupon is not yet valid.'];
} elseif (isset($coupon->status) && $coupon->status === 'inactive') {
$response = ['valid' => false, 'message' => 'Sorry, that coupon is inactive.'];
} else {
$response = ['valid' => true, 'message' => 'Coupon applied successfully!.'];
}

return ($response);
}