<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\ChatRoom;
use App\Models\EnquiryChat;
use App\Models\Message;
use App\Models\Company;
use App\Models\Enquiry;
use App\Models\Product;
use Inertia\Inertia;
use Carbon\Carbon;
use Auth;
use Session;
class EnquiryChatroomController extends Controller
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
    public function store($name,$product_id,$product_type)
    {
        $chatRoom = new ChatRoom();
        $chatRoom->name = $name;
        $chatRoom->product_id = $product_id;
        $chatRoom->product_type = $product_type;
        $chatRoom->message_at = Carbon::now()->toDateTimeString();
        $chatRoom->save();

        return $chatRoom;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,ChatRoom $chatroom)
    {
        $user = Auth::user();
        if($user->active_chatroom_id != $chatroom->id){
            $user->active_chatroom_id = $chatroom->id;
            $user->save();
        }


        $auth_member = $chatroom->members->where('id',Auth::user()->id)->first();
        if($auth_member->pivot->chat_left == 0){
            $messages = $chatroom->messages->where('id','>',$auth_member->pivot->messages_deleted_till);
        }else{
            $messages = $chatroom->messages->where('id','>',$auth_member->pivot->messages_deleted_till)->where('id','<',$auth_member->pivot->chat_left_at);
        }
        if($request->wantsJson()){
            return $messages;
        }

        $chatroom->messages->each(function ($message) use ($chatroom, $user) {
            $message->readBy($chatroom)->syncWithoutDetaching([$user->id => ['chatroom_id' => $chatroom->id]]);
        });

        $lastMessage = $chatroom->lastMessage;

        $readBy = $lastMessage->readBy($chatroom)->get();

        return Inertia::render('Enquiry/ChatRoom/Show',compact('chatroom','messages','auth_member','readBy'));
    }

    public function tempshow(Sale $sale){
        return Inertia::render('Enquiry/ChatRoom/TempShow',compact('sale'));
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
    public function destroy($id)
    {
        //
    }

    public function settings(ChatRoom $chatroom){
        $members = $chatroom->members()->where('chat_left','0')->get();
        $memberCount =  $members->count();

        $company = Company::where('id',Auth::user()->company_id)->first();
        $employees = $company->users->where('id','!=',Auth::user()->id);
        $auth_member = $chatroom->members->where('id',Auth::user()->id)->first();

        if($chatroom->product_type == 'sales'){
            $product = Sale::where('id',$chatroom->product_id)->first();
        }

        if($chatroom->product_type == 'enquiry'){
            $product = Enquiry::where('id',$chatroom->product_id)->first();
        }

        if($chatroom->product_type == 'product'){
            $product = Product::where('id',$chatroom->product_id)->first();
        }
        return Inertia::render('Enquiry/ChatRoom/Settings',compact('chatroom','members','memberCount','employees','auth_member','product'));
    }

    public function addUser(Request $request, $id){
        $chatroom = ChatRoom::where('id',$id)->first();
        $enquiryChat = $chatroom->enquiryChats()->first();

        foreach($request->staff as $staff){
            if(EnquiryChat::where('user_id',$staff)->where('cas_no',$enquiryChat->cas_no)->exists()){
                $staffEnquiryChat = EnquiryChat::where('user_id',$staff)->where('cas_no',$enquiryChat->cas_no)->first();
            }else{
                $enquiryChatController = new EnquiryChatsController();
                $staffEnquiryChat = $enquiryChatController->store($staff,$enquiryChat->product_name,$enquiryChat->cas_no);
            }

            if(!$staffEnquiryChat->chatRooms->contains($id)){
                $staffEnquiryChat->chatRooms()->attach($id);
            }
            if(!$chatroom->members->contains($staff)){
                $chatroom->members()->attach($staff);
            }
        }

        Session::flash('tag','Members added sucessfully!');
    }
}
