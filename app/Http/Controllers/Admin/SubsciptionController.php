<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Subscription;
use Auth;
use Session;
class SubsciptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subscriptions = Subscription::paginate();
        if($request->wantsJson()){
            return $subscriptions;
        }
        return Inertia::render('Admin/Subscription/Index',compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Subscription/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'price' => ['required','numeric'],
            'months' => ['required','numeric'],
            'days' => ['required','numeric'],
        ]);

        $subscription = new Subscription();
        $subscription->created_by = Auth::user()->id;
        $subscription->code = $this->generateUniqueCode();
        $subscription->months = $request->months;
        $subscription->days = $request->days;
        $subscription->price = $request->price;
        $subscription->save();

        Session::flash('toast','Subscription pack added sucessfully!!');

        return redirect(route('admin.subscription.index'));
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

        if (Subscription::where('code', $code)->exists()) {  
        $this->generateUniqueCode(); 
        }  
        return '#SUB'.$code;    
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
    public function edit(Subscription $subscription)
    {
        return Inertia::render('Admin/Subscription/Edit',compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->price = $request->price;
        $subscription->months = $request->months;
        $subscription->days = $request->days;
        $subscription->save();

        Session::flash("toast","Subscription updated sucessfully!!");

        return redirect(route('admin.subscription.index'));
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

    public function updateStatus(Request $request,Subscription $subscription){
        $subscription->active = $request->status;
        $subscription->save();

        return $subscription;
    }
}
