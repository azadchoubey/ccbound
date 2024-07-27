<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Auth;
use Session;
class CompanyController extends Controller
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
    public function show($id)
    {   
        $company = Company::where('id',$id)->first();
        $company->canEdit = Auth::user()->company_id == intval($id) && Auth::user()->role == 'admin' ? true :false;
        $employees = $company->users;
        foreach($employees as $employee) {
            if(Auth::user()->company_id == intval($id)) {
                $enquiries = $company->enquiries()->orderBy('updated_at','DESC')->paginate();
                $sales = $company->sales()->orderBy('updated_at','DESC')->paginate();
            } else {
                $enquiries = $company->enquiries()->where('expiry_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('updated_at','DESC')->paginate();
                $sales = $company->sales()->where('expiry_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('updated_at','DESC')->paginate();
            }

            $products = $company->products()->where('approved',1)->orderBy('updated_at','DESC')->paginate();
        }
        
        return Inertia::render('Company/Show',compact('company','employees','enquiries','sales','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $countries = Country::all();
        return Inertia::render('Company/Edit',compact('company','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validation = $request->validate([
            'name' => ['required','string','max:255'],
            'website' => ['required','string','max:255'],
            'type' => ['nullable','string','max:255'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required','string','max:255'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);


        $input = $request->all();
        if (isset($input['logo'])) {
            if($company->logo) {
                $logoWillDelete = public_path() . '/storage/company_logo/'.$company->logo;
                
                if(File::exists($logoWillDelete)) {
                    File::delete($logoWillDelete);
                }
                
            }
            
            
            $logoWithExt = request()->file('logo')->getClientOriginalName();
            $logo = pathinfo($logoWithExt,PATHINFO_FILENAME);
            $extension = request()->file('logo')->getClientOriginalExtension();
            $logoNameToStore = $logo.'_'.time().'.'.$extension;
            // request()->file('logo')->storeAs('company_logo',$logoNameToStore);
            request()->file('logo')->move(public_path('storage/company_logo'), $logoNameToStore);

            $company->forFill(['logo'=>$logoNameToStore])->save();
        }
        
        $company->forceFill([
            'name' => $input['name'],
            'website' => $input['website'],
            'type' => $input['type'],
            'country' => $input['country'],
            'state' => $input['state'],
            'city' => $input['city'],
            'address' => $input['address'],
        ])->save();

        Session::flash('tag',"Company Profile updated successfully!!");
    }
    
    public function updateLogo(Request $request, Company $company){
        $validation = $request->validate([
            'logo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);
        
        $logoWillDelete = public_path() . '/storage/company_logo/'.$company->logo;
        // File::delete($logoWillDelete);

        if($company->logo) {
            
            if(File::exists($logoWillDelete)) {
                File::delete($logoWillDelete);
            }
            
        }
        
        $logoWithExt = request()->file('logo')->getClientOriginalName();
        $logo = pathinfo($logoWithExt,PATHINFO_FILENAME);
        $extension = request()->file('logo')->getClientOriginalExtension();
        $logoNameToStore = $logo.'_'.time().'.'.$extension;
        // request()->file('logo')->storeAs('company_logo',$logoNameToStore);
        request()->file('logo')->move(public_path('storage/company_logo'), $logoNameToStore);
        
        $company->forceFill(['logo'=>$logoNameToStore])->save();
        Session::flash('tag',"Company Logo updated successfully!!");
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

    public function manage(){
        return Inertia::render('Company/Manage');
    }

    public function getEmployees(Request $request) {
        $query = User::query();
        
        $query->where('company_id', Auth::user()->company_id);
        
        if($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $employees = $query->paginate(5);

        return response()->json($employees);
    }
}
