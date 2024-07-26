<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\Product;
use Inertia\Inertia;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $profile = User::where('id', $id)->first();
       
        $profile->canEdit = Auth::user()->id == intval($id) ? true : false;

        if (Auth::user()->id == intval($id)) {
           
            $enquiries = $profile->enquiries()->orderBy('updated_at', 'DESC')->paginate();
            $sales = $profile->sales()->orderBy('updated_at', 'DESC')->paginate();
            $products = $profile->products()->orderBy('updated_at', 'DESC')->paginate();
            
        } else {
            $enquiries = $profile->enquiries()->where('expiry_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('updated_at', 'DESC')->paginate();
            $sales = $profile->sales()->where('expiry_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('updated_at', 'DESC')->paginate();
            $products = $profile->products()->where('approved', 1)->orderBy('updated_at', 'DESC')->paginate();
        }
        // $products = $profile->products()->where('approved',1)->orderBy('updated_at','DESC')->paginate();

        if ($request->tab == 'enquiry' && $request->wantsJson()) {
            return $enquiries;
        }

        if ($request->tab == 'sales' && $request->wantsJson()) {
            return $sales;
        }

        if ($request->tab == 'products' && $request->wantsJson()) {
            return $products;
        }

        $authID = Auth::user()->id;
        
        return Inertia::render("Profile", compact('profile', 'enquiries', 'sales', 'products', 'authID'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $countries = Country::all();
        return Inertia::render('Profile/Show', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
