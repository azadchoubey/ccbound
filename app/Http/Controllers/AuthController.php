<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Country;
use App\Models\Logo;

class AuthController extends Controller
{
    public function register(Request $request){
        $referrer = NULL;
        $countries = Country::all();
        if($request->referrer){
            $referrer = User::where('id',$request->referrer)->first();
        }

        $logo = Logo::first();
        return Inertia::render('Auth/Register',compact('referrer','countries','logo'));
    }

    public function getLogo() {
        $logo = Logo::first();
        return response()->json($logo);
    }
}
