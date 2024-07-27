<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Company;
use App\Models\SaleStaff;
use Auth;
use Session;
use DateTime;
use App\Models\EnquiryChat;
use App\Models\ChatRoomMember;
use App\Models\City;
use App\Models\Country;
use App\Models\SaleChat;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\Message;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterCountry = null;

        $salesQuery = Sale::query();
        $salesQuery->where('sale_show', 1)->where('active', 1)->orderBy('updated_at', 'DESC');

        $salesQuery->where('approved', 1)->where('expiry_date', '>=', date('Y-m-d') . ' 00:00:00');

        if ($request->country && $request->country != "null") {
            $salesQuery->where('country', $request->country);
        }
        if ($request->state && $request->state != "null") {
            $salesQuery->where('state', $request->state);
        }
        if ($request->city && $request->city != "null") {
            $salesQuery->where('city', $request->city);
        }


        if ($request->search != null) {

            $salesQuery->where(function ($query) use ($request) {
                $query->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
            });
        }


        $sales = $salesQuery->paginate(10);
        if ($request->wantsJson()) {
            return $sales;
        }

        $productQuery = Product::query();
        $productQuery->where('approved', '1');
        $productQuery->where('active', 1);

        if ($request->city) {
            $productQuery->where('city', $request->city);
            $filterCity = City::where('id', $request->city)->first();
        }
        if ($request->state) {
            $productQuery->where('state', $request->state);
            $filterState = State::where('id', $request->state)->first();
        }
        if ($request->country) {
            $productQuery->where('country', $request->country);
            $filterCountry = Country::where('id', $request->country)->first();
            
        }

        if ($request->search) {
            $productQuery->where(function ($query) use ($request) {
                $query->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
            });
        }

        $products = $productQuery->paginate(10);

        $countries = Country::all();
        return Inertia::render('Sales/Index', compact('sales', 'products', 'countries', 'filterCountry', 'filterState', 'filterCity'));
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
        $contacts = Auth::user()->contacts;
        $countries = Country::all();
        return Inertia::render('Sales/Create', compact('employees', 'contacts', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'country' => ['required'],
        ]);

        if ($request->people) {
            if ($request->quote == NULL || $request->quote == '') {
                Session::flash("toast", "Quote cannot be empty!!");
                return;
            }
        }

        $structureNameToStore = NULL;
        $docsNameToStore = NULL;

        if ($request->hasFile('structure')) {
            $structureWithExt = request()->file('structure')->getClientOriginalName();
            $structure = pathinfo($structureWithExt, PATHINFO_FILENAME);
            $extension = request()->file('structure')->getClientOriginalExtension();
            $structureNameToStore = $this->structureName($structure, $extension);
            // request()->file('structure')->storeAs('sale_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/sale_structure'), $structureNameToStore);
        }

        if ($request->hasFile('docs')) {
            $docsWithExt = request()->file('docs')->getClientOriginalName();
            $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
            $extension = request()->file('docs')->getClientOriginalExtension();
            $docsNameToStore = $this->docsName($docs, $extension);
            // request()->file('docs')->storeAs('sale_docs', $docsNameToStore);
            request()->file('docs')->move(public_path('storage/sale_docs'), $docsNameToStore);
        }

        $sale = new Sale();
        $sale->created_by = Auth::user()->id;
        $sale->user_id = Auth::user()->id;
        $sale->product_name = $request->productName;
        $sale->cas_no = $request->casNo;
        $sale->quantity_required = $request->quantityRequired;
        $sale->purity_required = $request->purityRequired;
        $sale->structure = $structureNameToStore;
        $sale->description = $request->description;
        $sale->docs = $docsNameToStore;
        $sale->sale_show = $request->sale;
        $sale->country = $request->country;
        $sale->state = $request->state;
        $sale->city = $request->city;
        $sale->approved = 0;
        $sale->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$sale->staff->contains($staff)) {
                    $sale->staff()->attach($staff);
                }
            }
        }

        if ($request->people) {
            foreach ($request->people as $person) {
                $this->sendMessage($sale, $person, $request->quote);
            }
        }

        Session::flash('toast', 'Sale Added successfully!!');

        return redirect(route('sales.index'));
    }

    public function structureName($logo, $extension)
    {
        $name = $logo . '_' . time() . '.' . $extension;
        $count = 0;

        while (Sale::where('structure', $name)->exists()) {
            $count++;
            $name = $logo . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function docsName($doc, $extension)
    {
        $name = $doc . '_' . time() . '.' . $extension;
        $count = 0;

        while (Sale::where('docs', $name)->exists()) {
            $count++;
            $name = $doc . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function sendMessage(Sale $sale, $user, $quote)
    {
        $enquiryChatrooms = array();
        $saleChatrooms = array();

        $person = User::where('id', $user['id'])->first();

        if (EnquiryChat::where('user_id', $person->id)->where('cas_no', $sale->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', $person->id)->where('cas_no', $sale->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChatController = new EnquiryChatsController();
            $enquiryChat = $enquiryChatController->store($person->id, $sale->product_name, $sale->cas_no);
        }

        if (SaleChat::where('user_id', $sale->user_id)->where('cas_no', $sale->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', $sale->user_id)->where('cas_no', $sale->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            $saleChatController = new SaleChatsController();
            $saleChat = $saleChatController->store($sale->user_id, $sale->product_name, $sale->cas_no);
        }

        $chatroom = false;

        foreach ($enquiryChatrooms as $enquiryChatroom) {
            foreach ($saleChatrooms as $saleChatroom) {
                if ($enquiryChatroom->chatroom_id == $saleChatroom->chatroom_id) {
                    $chatroom = $enquiryChatroom;
                    if ($chatroom->product_id != $sale->id || $chatroom->product_type != 'sales') {
                        $chatroom->product_id = $sale->id;
                        $chatroom->product_type = 'sales';
                        $chatroom->save();
                    }
                    break;
                }
            }
        }

        if (!$chatroom) {
            $user = $person;
            $company = Company::where('id', $user->company_id)->first();
            $chatRoomName = $sale->product_name . '-' . $sale->cas_no . ' - ' . $user->name . '@' . $company->name;

            $chatRoomController = new EnquiryChatroomController();
            $chatroom = $chatRoomController->store($chatRoomName, $sale->id, 'sales');
        }

        if (!$enquiryChat->chatRooms->contains($chatroom->id)) {
            $enquiryChat->chatRooms()->attach($chatroom->id);
        }

        // dd(!$saleChat->chatRooms->contains($chatroom->id));
        if (!$saleChat->chatRooms->contains($chatroom->id)) {
            $saleChat->chatRooms()->attach($chatroom->id);
        }

        if (!$chatroom->members->contains(Auth::user()->id)) {
            $chatroom->members()->attach(Auth::user()->id);
            // $chatroom->members()->attach(Auth::user()->id,['is_admin'=>1]);
        }

        if (!$chatroom->members->contains($person->id)) {
            $chatroom->members()->attach($person->id);
            // $chatroom->members()->attach($sale->user_id,['is_admin'=>1]);
        }

        // $saleStaff = $sale->staff;
        $saleStaff = User::leftJoin('sale_staff', 'users.id', '=', 'sale_staff.user_id')
            ->where('sale_staff.sale_id', $sale->id)
            ->select('users.*')
            ->get();

        foreach ($saleStaff as $staff) {
            if (SaleChat::where('user_id', $staff->id)->where('cas_no', $sale->cas_no)->exists()) {
                $saleChat = SaleChat::where('user_id', $staff->id)->where('cas_no', $sale->cas_no)->first();
            } else {
                $saleChatController = new SaleChatsController();
                $saleChat = $saleChatController->store($staff->id, $sale->product_name, $sale->cas_no);
            }

            if (!$saleChat->chatRooms->contains($chatroom->id)) {
                $saleChat->chatRooms()->attach($chatroom->id);
            }
            if (!$chatroom->members->contains($staff->id)) {
                $chatroom->members()->attach($staff->id);
            }
        }

        $message = new Message();
        $message->chatroom_id = $chatroom->id;
        $message->user_id = Auth::user()->id;
        $message->message = $quote;
        $message->save();

        $saleUser = User::where('id', $sale->user_id)->first();

        if (!$person->contacts->contains($saleUser->id)) {
            $person->contacts()->attach($saleUser->id);
        }

        if (!$saleUser->contacts->contains($person->id)) {
            $saleUser->contacts()->attach($person->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return Inertia::render('Sales/Show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $company = Company::where('id', Auth::user()->company_id)->first();
        $employees = $company->users->where('id', '!=', Auth::user()->id);
        $staffDetails = $sale->staff;
        $countries = Country::all();
        $contacts = Auth::user()->contacts;
        return Inertia::render('Sales/Edit', compact('employees', 'contacts', 'sale', 'staffDetails', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        if ($request->type == 'remove_staff') {
            $sale->staff()->detach($request->staff['id']);
            Session::flash('taost', 'User removed Successfully!!');
            return;
        }

        if ($request->type == 'status_update') {
            if ($request->status === 'activate') {
                $date = new DateTime();
                $date->modify('+14 day')->format('Y-m-d');

                $sale->expiry_date = $date;
            } else if ($request->status === 'deactivate') {
                $sale->expiry_date = NULL;
                $sale->active = 0;
            }
            $sale->save();
            return $sale;
        }
        $request->validate([
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'country' => ['required'],
        ]);
        $request->validate([
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'country' => ['required'],
        ]);

        $sale->product_name = $request->productName;
        $sale->cas_no = $request->casNo;
        $sale->quantity_required = $request->quantityRequired;
        $sale->purity_required = $request->purityRequired;
        $sale->description = $request->description;
        $sale->sale_show = $request->sale;
        $sale->country = $request->country;
        $sale->state = $request->state;
        $sale->city = $request->city;
        $sale->expiry_date = $sale->expiry_date ? $sale->expiry_date : null;
        $sale->approved_by = $sale->approved_by ? $sale->approved_by : null;
        $sale->approved = 0;
        $sale->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$sale->staff->contains($staff)) {
                    $sale->staff()->attach($staff);
                }
            }
        }

        if ($request->structure == 'no image' && $sale->structure) {
            $old_structure = public_path('storage/sale_structure/' . $sale->structure);

            if ($sale->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }

            // $structureNameToStore = $request->structure;
            $sale->structure = null;
            $sale->save();
        }

        if ($request->docs == 'no doc' && $sale->docs) {
            $old_docs = public_path('storage/sale_docs/' . $sale->docs);

            if ($sale->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }

            // $docsNameToStore = $request->docs;
            $sale->docs = null;
            $sale->save();
        }


        if ($request->hasFile('structure')) {

            $old_structure = public_path('storage/sale_structure/' . $sale->structure);

            if ($sale->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }

            $structureWithExt = request()->file('structure')->getClientOriginalName();
            $structure = pathinfo($structureWithExt, PATHINFO_FILENAME);
            $extension = request()->file('structure')->getClientOriginalExtension();
            $structureNameToStore = $this->structureName($structure, $extension);
            // request()->file('structure')->storeAs('sale_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/sale_structure'), $structureNameToStore);
            $sale->structure = $structureNameToStore;
            $sale->save();
        }

        if ($request->hasFile('docs')) {

            $old_docs = public_path('storage/sale_docs/' . $sale->docs);
            if ($sale->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }

            $docsWithExt = request()->file('docs')->getClientOriginalName();
            $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
            $extension = request()->file('docs')->getClientOriginalExtension();
            $docsNameToStore = $this->docsName($docs, $extension);
            // request()->file('docs')->storeAs('sale_docs', $docsNameToStore);
            request()->file('docs')->move(public_path('storage/sale_docs'), $docsNameToStore);
            $sale->docs = $docsNameToStore;
            $sale->save();
        }

        if ($request->people) {
            foreach ($request->people as $person) {
                $this->sendMessage($sale, $person, $request->quote);
            }
        }

        Session::flash('toast', 'Sales updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $structure = public_path('storage/sale_structure/' . $sale->structure);

        if ($sale->structure && File::exists($structure)) {

            File::delete($structure);
        }

        $docs = public_path('storage/sale_docs/' . $sale->docs);
        if ($sale->docs && File::exists($docs)) {

            File::delete($docs);
        }

        $sale->delete();

        Session::flash('toast', 'Sale Deleted Successfully!!');
    }
}
