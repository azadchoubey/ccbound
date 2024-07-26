<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function states($country){
        return State::where('country_id',$country)->get();
    }

    public function cities($state){
        return City::where('state_id',$state)->get();
    }
}
