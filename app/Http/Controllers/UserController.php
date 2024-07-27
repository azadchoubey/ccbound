<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Wallet;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Session;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('company_id', Auth::user()->company_id)->where('id', '!=', Auth::user()->id)->paginate();
        return Inertia::render('User/Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return Inertia::render('User/Create', compact('countries'));
    }

    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'number' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['nullable'],
        ]);

        $input = $request->all();
        $user = User::create([
            'created_by' => Auth::user()->id,
            'admin' => Auth::user()->id,
            'name' => $input['name'],
            'email' => $input['email'],
            'number' => $input['number'],
            'password' => Hash::make($input['password']),
            'company_id' => Auth::user()->company_id,
            'address' => $input['address'],
            'country' => $input['country'],
            'state' => $input['state'],
            'city' => $input['city'],
            'role' => 'user',
        ]);

        Session::flash('toast', 'User created Successfully!');

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->amount = 0;
        $wallet->save();

        return redirect(route('users.index'));
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
    public function edit(User $user)
    {
        $countries = Country::all();
        return Inertia::render('User/Edit', compact('user', 'countries'));
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
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->state;
        $user->password = Hash::make($request->password);
        $user->save();

        Session::flash('toast', "User updated successfully!!");
        return redirect(route('users.index'));
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

    public function updateRole(Request $request, User $user)
    {
        $user->role = $request->role;
        $user->save();

        return redirect(route('users.index'));
    }
}
