<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sale;
use Auth;
use DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Sale::orderBy('approved', 'ASC')->orderBy('active', 'ASC');

        if($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->search . '%')->orWhere('cas_no', 'like', '%' . $request->search . '%');
            });
        }

        $sales = $query->orderBy('created_at', 'DESC')->paginate(8);

        if ($request->wantsJson()) {
            return $sales;
        }

        return Inertia::render('Admin/Sales/Index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return Inertia::render('Admin/Sales/Create');
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
        return Inertia::render('Admin/Sales/Edit');
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
    public function destroy(Sale $sale)
    {
        if ($sale->structure) {
            $structure = public_path() . '/storage/enquiry_structure/' . $sale->structure;
            if(File::exists($structure)) {
                File::delete($structure);
            }
            
        }

        if ($sale->docs) {
            $docs = public_path() . '/storage/enquiry_docs/' . $sale->docs;

            if(File::exists($docs)) {
                File::delete($docs);
            }
            
        }

        $sale->delete();

        Session::flash('toast', 'Sale Deleted Sucessfully!!');
    }

    public function updateStatus(Request $request, Sale $sale)
    {
        $sale->approved_by = Auth::user()->id;
        $sale->approved = $request->status;
        $sale->active = $request->active;

        if ($request->status == 1) {
            $date = new DateTime();
            $date->modify('+14 day')->format('Y-m-d');
            $sale->expiry_date = $date;
        }

        if ($request->active == 0) {
            $sale->expiry_date = NULL;
        }

        $sale->save();

        return $sale;
    }
}
