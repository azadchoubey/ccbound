<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class RedirectController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            if (auth()->user()->role == 'user' || auth()->user()->role == 'admin') {
                return redirect(route('enquiry.index'));
            } else if (auth()->user()->role == 'super_admin') {
                return redirect(route('admin.user.index'));
            } else if (auth()->user()->role == 'accounts_admin') {
                return redirect(route('admin.user.index'));
            } else if (auth()->user()->role == 'data_admin') {
                return redirect(route('admin.uploadpack.showlist'));
            } else if (auth()->user()->role == 'sales_admin') {
                return redirect(route('admin.coupon.index'));
            }
        } else {
            return redirect('login');
        }
    }
}
