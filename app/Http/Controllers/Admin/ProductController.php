<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Auth;
use DateTime;
use Illuminate\Support\Facades\File;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productsQuery = Product::orderBy('approved', 'ASC')->orderBy('active', 'ASC')->orderBy('created_at', 'DESC');

        if($request->search) {
            $productsQuery->where(function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->search . '%')->orWhere('cas_no', 'like', '%' . $request->search . '%');
            });
        }

        $products = $productsQuery->paginate(8);
        if ($request->wantsJson()) {
            return $products;
        }
        return Inertia::render('Admin/Product/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user)
    {
        return Inertia::render('Admin/Product/Create');
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
    public function destroy(Product $product)
    {
        if ($product->structure) {
            $structure = public_path() . '/storage/enquiry_structure/' . $product->structure;
            if(File::exists($structure)) {
                File::delete($structure);
            }
        }

        if ($product->docs) {
            $docs = public_path() . '/storage/enquiry_docs/' . $product->docs;
            if(File::exists($docs)) {
                File::delete($docs);
            }
        }

        $product->delete();

        Session::flash('toast', 'Product Deleted Successfully!!');
    }

    public function updateStatus(Request $request, Product $product)
    {
        $product->approved_by = Auth::user()->id;
        $product->approved = $request->status;
        $product->active = $request->active;
        $product->save();

        return $product;
    }
}
