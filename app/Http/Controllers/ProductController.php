<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
// use File;
use Illuminate\Support\Facades\File;
use Auth;
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
        $filterCountry = null;

        $productsQuery = Product::query();
        $productsQuery->where('approved', '1')->where('active', 1);
        $productsQuery->orderBy('updated_at', 'DESC');
        
        if ($request->search) {
            $productsQuery->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
        }
       
        if ($request->country && $request->country!="null") {
            $productsQuery->where('country', $request->country);
            
            $filterCountry = Country::where('id', $request->country)->first();
        }
        if ($request->state && $request->state!="null") {
            $productsQuery->where('state', $request->state);
        }
        if ($request->city && $request->city!="null") {
            $productsQuery->where('city', $request->city);
        }
        
        $products = $productsQuery->paginate(4);
        if ($request->wantsJson()) {
            return $products;
        }

        $countries = Country::all();

        return Inertia::render('Product/Index', compact('products', 'countries','filterCountry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::where('id', Auth::user()->company_id)->first();
        $employees = $company->users->where('id', '!=', Auth::user()->id);
        $countries = Country::all();
        return Inertia::render('Product/Create', compact('employees', 'countries'));
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
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'country' => ['required'],
        ]);

        $structureNameToStore = NULL;
        $docsNameToStore = NULL;

        if ($request->hasFile('structure')) {
            $structureWithExt = request()->file('structure')->getClientOriginalName();
            $structure = pathinfo($structureWithExt, PATHINFO_FILENAME);
            $extension = request()->file('structure')->getClientOriginalExtension();
            $structureNameToStore = $this->structureName($structure, $extension);
            // request()->file('structure')->storeAs('product_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/product_structure'), $structureNameToStore);
        }

      
        if ($request->hasFile('docs')) {
            foreach ($request->file('docs') as $file) {
                $docsWithExt = $file->getClientOriginalName();
                $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $docsNameToStore[] = $this->docsName($structure, $extension);
                $file->move(public_path('storage/product_docs'), $this->docsName($structure, $extension));
            }
        }

        $product = new Product();
        $product->created_by = Auth::user()->id;
        $product->user_id = Auth::user()->id;
        $product->product_name = $request->productName;
        $product->cas_no = $request->casNo;
        $product->structure = $structureNameToStore;
        $product->type = $request->type;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->docs = json_encode($docsNameToStore);
        $product->country = $request->country;
        $product->state = $request->state;
        $product->city = $request->city;
        $product->approved = 0;
        $product->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$product->staff->contains($staff)) {
                    $product->staff()->attach($staff);
                }
            }
        }

        Session::flash('toast', 'Product Added sucessfully!!');

        return redirect(route('product.index'));
    }

    public function structureName($logo, $extension)
    {
        $name = $logo . '_' . time() . '.' . $extension;
        $count = 0;

        while (Product::where('structure', $name)->exists()) {
            $count++;
            $name = $logo . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function docsName($doc, $extension)
    {
        $name = $doc . '_' . time() . '.' . $extension;
        $count = 0;

        while (Product::where('docs', $name)->exists()) {
            $count++;
            $name = $doc . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Product/Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $company = Company::where('id', Auth::user()->company_id)->first();
        $employees = $company->users->where('id', '!=', Auth::user()->id);
        $staffDetails = $product->staff;
        $countries = Country::all();

        return Inertia::render('Product/Edit', compact('employees', 'product', 'staffDetails', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, Request $request)
    {
       
        if ($request->type == 'remove_staff') {
            $product->staff()->detach($request->staff['id']);
            Session::flash('toast', 'User removed Successfully!!');
            return;
        }

        $request->validate([
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'country' => ['required'],
        ]);

        $structureNameToStore = $product->structure;
        $docsNameToStore = $product->docs;

        if(!$request->structure && $product->structure) {
            $old_structure = public_path('storage/product_structure/' . $product->structure);

            if ($product->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }

            $structureNameToStore = $request->structure;
        }
        
        if(!$request->docs && $product->docs) {
            
            $old_docs = public_path('storage/product_docs/' . $product->docs);

            if ($product->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }
            $docsNameToStore = $request->docs;
        }


        if ($request->hasFile('structure')) {

            $old_structure = public_path('storage/product_structure/' . $product->structure);

            if ($product->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }

            $structureWithExt = request()->file('structure')->getClientOriginalName();
            $structure = pathinfo($structureWithExt, PATHINFO_FILENAME);
            $extension = request()->file('structure')->getClientOriginalExtension();
            $structureNameToStore = $this->structureName($structure, $extension);
            // request()->file('structure')->storeAs('enquiry_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/product_structure'), $structureNameToStore);
        }

        if ($request->hasFile('docs')) {

            $old_docs = public_path('storage/product_docs/' . $product->docs);
            if ($product->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }

            $docsWithExt = request()->file('docs')->getClientOriginalName();
            $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
            $extension = request()->file('docs')->getClientOriginalExtension();
            $docsNameToStore = $this->docsName($docs, $extension);
            // request()->file('docs')->storeAs('enquiry_docs', $docsNameToStore);
            request()->file('docs')->move(public_path('storage/product_docs'), $docsNameToStore);
        }


        $product->product_name = $request->productName;
        $product->cas_no = $request->casNo;
        $product->type = $request->type;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->structure = $structureNameToStore;
        $product->docs = $docsNameToStore;
        $product->country = $request->country;
        $product->state = $request->state;
        $product->city = $request->city;
        $product->approved_by = $product->approved_by ? $product->approved_by : null;
        $product->approved = 0;
        $product->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$product->staff->contains($staff)) {
                    $product->staff()->attach($staff);
                }
            }
        }

        Session::flash('toast', 'Product updated sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        
        $structure = public_path('storage/product_structure/' . $product->structure);
        
        if ($product->structure && File::exists($structure)) {
            File::delete($structure);
        }

        $docs = public_path('storage/product_docs/' . $product->docs);
        if ($product->docs && File::exists($docs)) {
            File::delete($docs);
        }

        $product->delete();

        Session::flash('toast', 'Product Deleted Sucessfully!!');
    }

    public function share(Request $request, Product $product)
    {
        if ($product->structure) {
            $source = public_path() . '/storage/product_structure/' . $product->structure;
            $destiny = public_path() . '/storage/sale_structure/' . $product->structure;
            // return $source;
            File::copy($source, $destiny);
        }

        if ($product->docs) {
            $source = public_path() . '/storage/product_docs/' . $product->docs;
            $destiny = public_path() . '/storage/sale_docs/' . $product->docs;
            File::copy($source, $destiny);
        }
        $sale = new Sale();
        $sale->created_by = Auth::user()->id;
        $sale->user_id = Auth::user()->id;
        $sale->product_name = $product->product_name;
        $sale->cas_no = $product->cas_no;
        $sale->structure = $product->structure;
        $sale->description = $product->description;
        $sale->docs = $product->docs;
        $sale->sale_show = 1;
        $sale->country = $product->country;
        $sale->state = $product->state;
        $sale->city = $product->city;
        $sale->save();

        if ($product->staff) {
            foreach ($product->staff as $staff) {
                if (!$sale->staff->contains($staff)) {
                    $sale->staff()->attach($staff);
                }
            }
        }

        // Session::flash('toast','Product shared to sales sucessfully!!');
    }
}
