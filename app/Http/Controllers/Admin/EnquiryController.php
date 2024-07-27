<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Enquiry;
use Auth;
use DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $enquiriesQuery = Enquiry::orderBy('approved', 'ASC')->orderBy('active', 'ASC');
        
        if($request->search) {
            $enquiriesQuery->where(function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->search . '%')->orWhere('cas_no', 'like', '%' . $request->search . '%');
            });
        }
        

        if ($request->approved != null) {
            $enquiriesQuery->where('approved', $request->approved);
        }

        $enquiries = $enquiriesQuery->orderBy('created_at', 'DESC')->paginate(8);


        if ($request->wantsJson()) {
            return $enquiries;
        }
        return Inertia::render('Admin/Enquiry/Index', compact('enquiries'));
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
        //
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
    public function destroy(Enquiry $enquiry)
    {
        if ($enquiry->structure) {
            
            $structure = public_path() . '/storage/enquiry_structure/' . $enquiry->structure;
            if (File::exists($structure)) {
                File::delete($structure);
            }
        }

        if ($enquiry->docs) {
            $docs = public_path() . '/storage/enquiry_docs/' . $enquiry->docs;
            if (File::exists($docs)) {
                File::delete($docs);
            }
        }

        $enquiry->delete();

        Session::flash('toast', 'Enquiry Deleted Successfully!!');
    }

    public function updateStatus(Request $request, Enquiry $enquiry)
    {   
        $enquiry->approved_by = Auth::user()->id;
        $enquiry->approved = $request->status;
        $enquiry->active = $request->active;

        if ($request->status == 1) {
            $date = new DateTime();
            $date->modify('+14 day')->format('Y-m-d');
            $enquiry->expiry_date = $date;
        }

        if ($request->active == 0) {
            $enquiry->expiry_date = NULL;
        }

        $enquiry->save();

        return $enquiry;
    }
}
