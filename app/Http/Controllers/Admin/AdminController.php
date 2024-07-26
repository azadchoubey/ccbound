<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Session;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $superadmin = User::where('role','super_admin')->count();
        $salesadmin = User::where('role','sales_admin')->count();
        $accountsadmin = User::where('role','accounts_admin')->count();
        $dataadmin = User::where('role','data_admin')->count();

        $query = User::query();
        $query->where(function($query){
            $query->where('role','super_admin')->orWhere('role','accounts_admin')->orWhere('role','sales_admin')->orWhere('role','data_admin')->paginate();
        });

        if($request->search){
            $query->where(function($query) use ($request){
                $query->where('name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%')->orWhere('number','like','%'.$request->search.'%');
            });
        }

        $admins = $query->orderBy('created_at', 'DESC')->paginate();

        if($request->wantsJson()){
            return $admins;
        }

        return Inertia::render('Admin/Admin/Index',compact('superadmin','salesadmin','accountsadmin','dataadmin','admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Admin/Create');
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
            'role' => ['required'],
            'password' => $this->passwordRules(),
        ]);
        $user = new User();
        $user->created_by = Auth::user()->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->password = Hash::make($request->password);
        $user->company_id = Auth::user()->company_id;
        $user->role = $request->role;
        $user->save();

        Session::flash('toast',"Admin created sucessfully!!");

        return redirect(route('admin.admin.index'));
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
    public function edit(User $admin)
    {
        return Inertia::render('Admin/Admin/Edit',compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => $this->passwordRules(),
            'role' => ['required'],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->number = $request->number;
        $admin->password = Hash::make($request->password);
        $admin->role = $request->role;
        $admin->save();

        Session::flash('toast','Admin deatils updated sucessfully!');

        return redirect(route('admin.admin.index'));
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

    public function updateStatus(Request $request, User $admin){
        $admin->active = $request->status;
        $admin->save();

        return $admin;
    }

    public function createLogo() {
        $logo = Logo::first();
        return Inertia::render('Admin/Logo/Logo', compact('logo'));
    }

    public function storeLogo(Request $request) {
       
        $lastLogo = Logo::first();
        if ($lastLogo && File::exists(public_path($lastLogo->logo))) {
            File::delete($lastLogo->logo);
            $lastLogo->delete();
          
        }else{
            Logo::query()->delete();
        }


        if ($request->hasFile('logo')) {
            $logo = new Logo();
            
            $imageName = $request->logo->getClientOriginalName();
            
         $request->file('logo')->move(public_path('uploads'), $imageName);
            $logo->logo = 'uploads/'.$imageName;
            $logo->status = 1;
            $logo->save();
            
        }

        return redirect()->route('admin.logo.create');
    }
}
