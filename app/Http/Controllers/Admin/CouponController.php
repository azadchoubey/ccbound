<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Coupon;
use Auth;
use Session;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupons = Coupon::paginate();
        if($request->wantsJson()){
            return $coupons;
        }
        return Inertia::render('Admin/Coupon/Index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Coupon/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = new Coupon();
        $coupon->created_by = Auth::user()->id;
        $coupon->code = $this->generateUniqueCode();
        $coupon->discount = $request->discount;
        $coupon->save();

        Session::flash('toast',"Coupon created successfully!");

        return redirect(route('admin.coupon.index'));
    }

    public function generateUniqueCode() {  
        $characters = '0123456789';  
        $charactersNumber = strlen($characters);  
        $codeLength = 4;  

        $code = ''; 
        
        while (strlen($code) < 6) {  
            $position = rand(0, $charactersNumber - 1);  
            $character = $characters[$position];  
            $code = $code.$character; 
        }  

        if (Coupon::where('code', $code)->exists()) {  
        $this->generateUniqueCode(); 
        }  
        return '#COU'.$code;    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return Inertia::render('Admin/Coupon/Edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $coupon->discount = $request->discount;
        $coupon->save();

        Session::flash('toast','Coupone update successfully!');

        return redirect(route('admin.coupon.index'));
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

    public function updateStatus(Request $request, Coupon $coupon){
        $coupon->active = $request->status;
        $coupon->save();
        return $coupon;
    }
}
