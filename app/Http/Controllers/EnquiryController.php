<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Enquiry;
use App\Models\EnquiryStaff;
use App\Models\Company;
use App\Models\UserSubscription;
use App\Models\User;
use Auth;
use DateTime;
use Session;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\ChatRoomMember;
use App\Models\Country;
use App\Models\SaleChat;
use App\Models\EnquiryChat;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterCountry = null;

        $query = Enquiry::query();
        $query->where('enquiry_show', '1')->where('approved', '1')->where('active', 1)->where('expiry_date', '>=', date('Y-m-d') . ' 00:00:00')->orderBy('updated_at', 'DESC');

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
            });
            
        }

        if ($request->country && $request->country != "null") {
            $query->where('country', $request->country);
            
            $filterCountry = Country::where('id', $request->country)->first();
        }

        if ($request->state && $request->state != "null") {
            $query->where('state', $request->state);
        }

        if ($request->city && $request->city != "null") {
            $query->where('city', $request->city);
        }

        $enquiries = $query->paginate(10);
        if ($request->wantsJson()) {
            return $enquiries;
        }

        $countries = Country::all();
        return Inertia::render('Enquiry/Index', compact('enquiries', 'countries', 'filterCountry'));
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
        $countries = Country::with('states.cities')->get();
        return Inertia::render('Enquiry/Create', compact('employees', 'contacts', 'countries'));
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
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:51002'],
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
            // request()->file('structure')->storeAs('enquiry_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/enquiry_structure'), $structureNameToStore);
        }

        if ($request->hasFile('docs')) {
            $docsWithExt = request()->file('docs')->getClientOriginalName();
            $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
            $extension = request()->file('docs')->getClientOriginalExtension();
            $docsNameToStore = $this->docsName($structure, $extension);
            // request()->file('docs')->storeAs('enquiry_docs', $docsNameToStore);
            request()->file('docs')->move(public_path('storage/enquiry_docs'), $docsNameToStore);
        }

        $enquiry = new Enquiry();
        $enquiry->created_by = Auth::user()->id;
        $enquiry->user_id = Auth::user()->id;
        $enquiry->product_name = $request->productName;
        $enquiry->cas_no = $request->casNo;
        $enquiry->quantity_required = $request->quantityRequired;
        $enquiry->purity_required = $request->purityRequired;
        $enquiry->structure = $structureNameToStore;
        $enquiry->description = $request->description;
        $enquiry->docs = $docsNameToStore;
        $enquiry->enquiry_show = $request->enquiry;
        $enquiry->country = $request->country;
        $enquiry->state = $request->state;
        $enquiry->city = $request->city;
        $enquiry->approved = 0;
        $enquiry->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$enquiry->staff->contains($staff)) {
                    $enquiry->staff()->attach($staff);
                }
            }
        }

        if ($request->people) {
            foreach ($request->people as $person) {
                $this->sendMessage($enquiry, $person, $request->quote);
            }
        }

        Session::flash('toast', 'Enquiry Added successfully!!');
        return redirect(route('enquiry.index'));
    }

    public function structureName($logo, $extension)
    {
        $name = $logo . '_' . time() . '.' . $extension;
        $count = 0;

        while (Enquiry::where('structure', $name)->exists()) {
            $count++;
            $name = $logo . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function docsName($doc, $extension)
    {
        $name = $doc . '_' . time() . '.' . $extension;
        $count = 0;

        while (Enquiry::where('docs', $name)->exists()) {
            $count++;
            $name = $doc . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function sendMessage(Enquiry $enquiry, $user, $quote)
    {
        $enquiryChatrooms = array();
        $saleChatrooms = array();
        $person = User::where('id', $user['id'])->first();

        if (EnquiryChat::where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChatController = new EnquiryChatsController();
            $enquiryChat = $enquiryChatController->store($enquiry->user_id, $enquiry->product_name, $enquiry->cas_no);
        }

        if (SaleChat::where('user_id', $person->id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', $person->id)->where('cas_no', $enquiry->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            $saleChatController = new SaleChatsController();
            $saleChat = $saleChatController->store($person->id, $enquiry->product_name, $enquiry->cas_no);
        }

        $chatroom = false;

        foreach ($enquiryChatrooms as $enquiryChatroom) {
            foreach ($saleChatrooms as $saleChatroom) {
                if ($enquiryChatroom->chatroom_id == $saleChatroom->chatroom_id) {
                    $chatroom = $enquiryChatroom;
                    if ($chatroom->product_id != $enquiry->id || $chatroom->product_type != 'enquiry') {
                        $chatroom->product_id = $enquiry->id;
                        $chatroom->product_type = 'enquiry';
                        $chatroom->save();
                    }
                    break;
                }
            }
        }

        if (!$chatroom) {
            $user = User::where('id', $enquiry->user_id)->first();
            $company = Company::where('id', $user->company_id)->first();
            $chatRoomName = $enquiry->product_name . '-' . $enquiry->cas_no . ' - ' . $user->name . '@' . $company->name;

            $chatRoomController = new EnquiryChatroomController();
            $chatroom = $chatRoomController->store($chatRoomName, $enquiry->id, 'enquiry');
        }

        if (!$enquiryChat->chatRooms->contains($chatroom->id)) {
            $enquiryChat->chatRooms()->attach($chatroom->id);
        }

        if (!$saleChat->chatRooms->contains($chatroom->id)) {
            $saleChat->chatRooms()->attach($chatroom->id);
        }

        if (!$chatroom->members->contains(Auth::user()->id)) {
            $chatroom->members()->attach(Auth::user()->id);
            // $chatroom->members()->attach(Auth::user()->id,['is_admin'=>1]);
        }

        if (!$chatroom->members->contains($person->id)) {
            $chatroom->members()->attach($person->id);
            // $chatroom->members()->attach($enquiry->user_id,['is_admin'=>1]);
        }


        // $enquiryStaff = $enquiry->staff;
        $enquiryStaff = User::leftJoin('enquiry_staff', 'users.id', '=', 'enquiry_staff.user_id')
            ->where('enquiry_staff.enquiry_id', $enquiry->id)
            ->select('users.*')
            ->get();


        foreach ($enquiryStaff as $staff) {
            if (EnquiryChat::where('user_id', $staff->id)->where('cas_no', $enquiry->cas_no)->exists()) {
                $enquiryChat = EnquiryChat::where('user_id', $staff->id)->where('cas_no', $enquiry->cas_no)->first();
            } else {
                $enquiryChatController = new EnquiryChatsController();
                $enquiryChat = $enquiryChatController->store($staff->id, $enquiry->product_name, $enquiry->cas_no);
            }

            if (!$enquiryChat->chatRooms->contains($chatroom->id)) {
                $enquiryChat->chatRooms()->attach($chatroom->id);
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

        $enquiryUser = User::where('id', $enquiry->user_id)->first();
        // $authUser = $person;

        if (!$person->contacts->contains($enquiryUser->id)) {
            $person->contacts()->attach($enquiryUser->id);
        }

        if (!$enquiryUser->contacts->contains($person->id)) {
            $enquiryUser->contacts()->attach($person->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        return Inertia::render('Enquiry/Show', compact('enquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquiry $enquiry)
    {
        $company = Company::where('id', Auth::user()->company_id)->first();
        $employees = $company->users->where('id', '!=', Auth::user()->id);
        $staffDetails = $enquiry->staff;
        $countries = Country::with('states.cities')->get();
        $contacts = Auth::user()->contacts;
        return Inertia::render('Enquiry/Edit', compact('employees', 'enquiry', 'staffDetails', 'countries', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        if ($request->type == 'remove_staff') {
            $enquiry->staff()->detach($request->staff['id']);
            Session::flash('toast', 'User removed Successfully!!');
            return;
        }

        if ($request->type == 'status_update') {
            if ($request->status === 'activate') {
                $date = new DateTime();
                $date->modify('+14 day')->format('Y-m-d');

                $enquiry->expiry_date = $date;
            } else if ($request->status === 'deactivate') {
                $enquiry->expiry_date = NULL;
                $enquiry->active = 0;
            }
            $enquiry->save();
            return;
        }

        $request->validate([
            'productName' => ['required', 'string', 'max:255'],
            'casNo' => ['required', 'string', 'max:255', 'regex:/^[0-9-]+$/'],
            'structure' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:512'],
            'country' => ['required'],
        ]);

        $structureNameToStore = $enquiry->structure;
        $docsNameToStore = $enquiry->docs;

        if($request->structure=='no image' && $enquiry->structure) {
            $old_structure = public_path('storage/enquiry_structure/' . $enquiry->structure);

            if ($enquiry->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }

            $structureNameToStore = null;
        }

        if($request->docs == 'no doc' && $enquiry->docs) {
            $old_docs = public_path('storage/enquiry_docs/' . $enquiry->docs);

            if ($enquiry->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }
            
            $docsNameToStore = null;
        }

        if ($request->hasFile('structure')) {

            $old_structure = public_path('storage/enquiry_structure/' . $enquiry->structure);

            if ($enquiry->structure && File::exists($old_structure)) {

                File::delete($old_structure);
            }


            $structureWithExt = request()->file('structure')->getClientOriginalName();
            $structure = pathinfo($structureWithExt, PATHINFO_FILENAME);
            $extension = request()->file('structure')->getClientOriginalExtension();
            $structureNameToStore = $this->structureName($structure, $extension);
            // request()->file('structure')->storeAs('enquiry_structure', $structureNameToStore);
            request()->file('structure')->move(public_path('storage/enquiry_structure'), $structureNameToStore);
        }

        if ($request->hasFile('docs')) {
            $old_docs = public_path('storage/enquiry_docs/' . $enquiry->docs);

            if ($enquiry->docs && File::exists($old_docs)) {

                File::delete($old_docs);
            }

            $docsWithExt = request()->file('docs')->getClientOriginalName();
            $docs = pathinfo($docsWithExt, PATHINFO_FILENAME);
            $extension = request()->file('docs')->getClientOriginalExtension();
            $docsNameToStore = $this->docsName($docs, $extension);
            request()->file('docs')->move(public_path('storage/enquiry_docs'), $docsNameToStore);
            // request()->file('docs')->storeAs('enquiry_docs', $docsNameToStore);
        }

        $enquiry->product_name = $request->productName;
        $enquiry->cas_no = $request->casNo;
        $enquiry->quantity_required = $request->quantityRequired;
        $enquiry->purity_required = $request->purityRequired;
        $enquiry->description = $request->description;
        $enquiry->enquiry_show = $request->enquiry;
        $enquiry->structure = $structureNameToStore;
        $enquiry->docs = $docsNameToStore;
        $enquiry->country = $request->country;
        $enquiry->state = $request->state;
        $enquiry->city = $request->city;
        $enquiry->expiry_date = NULL;
        $enquiry->approved_by = NULL;
        $enquiry->approved = 0;
        $enquiry->save();

        if ($request->staff) {
            foreach ($request->staff as $staff) {
                if (!$enquiry->staff->contains($staff)) {
                    $enquiry->staff()->attach($staff);
                }
            }
        }

        if ($request->people) {
            foreach ($request->people as $person) {
                $this->sendMessage($enquiry, $person, $request->quote);
            }
        }

        Session::flash('toast', 'Enquiry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquiry $enquiry)
    {
        $structure = public_path('storage/enquiry_structure/' . $enquiry->structure);

        if ($enquiry->structure && File::exists($structure)) {

            File::delete($structure);
        }

        $docs = public_path('storage/enquiry_docs/' . $enquiry->docs);

        if ($enquiry->docs && File::exists($docs)) {

            File::delete($docs);
        }

        $enquiry->delete();

        Session::flash('toast', 'Enquiry Deleted Successfully!!');
    }
}
