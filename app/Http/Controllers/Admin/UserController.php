<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Company;
use Inertia\Inertia;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adminsCount = User::where('role', 'super_admin')->orWhere('role', 'accounts_admin')->orWhere('role', 'data_admin')->orWhere('role', 'sales_admin')->count();
        $usersCount = User::where('role', 'user')->orWhere('role', 'admin')->count();

        $trail = UserSubscription::where('subscription', '#SUB000000')->where('end_date', '>=', date('Y-m-d'))->sum('accounts');
        $notSubscribed = UserSubscription::where('subscription', '#SUB000000')->where('end_date', '<', date('Y-m-d'))->sum('accounts');
        $subscribed = UserSubscription::where('subscription', '!=', '#SUB000000')->where('end_date', '>=', date('Y-m-d'))->sum('accounts');
        $expired = UserSubscription::where('subscription', '!=', '#SUB000000')->where('end_date', '<', date('Y-m-d'))->sum('accounts');

        $query = User::query();
        $query->where(function ($query) {
            $query->where('role', 'user')->orWhere('role', 'admin');
        });

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->orWhere('number', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'DESC')->paginate();

        if ($request->wantsJson()) {
            return $users;
        }

        return Inertia::render('Admin/User/Index', compact('adminsCount', 'usersCount', 'trail', 'notSubscribed', 'subscribed', 'expired', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/User/Create');
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
    public function edit($id)
    {
        return Inertia::render('Admin/User/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->type == 'update_status') {
            $user->active = $request->status;
            $user->save();
            return $user;
        }
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

    public function pending()
    {
        // $data = Company::with('users')::whereHas('subscription',function($query){
        //     $query->where('end_date','<',date('Y-m-d'));
        // })->paginate();

        // return $data;
        return Inertia::render('Admin/User/Pending');
    }
}
