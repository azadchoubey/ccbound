<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validateCoupon($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();
        if (!$coupon) {
            return 0;
        }
        if ($coupon->active) {
            return $coupon;
        } else {
            return 0;
        }
    }
}
