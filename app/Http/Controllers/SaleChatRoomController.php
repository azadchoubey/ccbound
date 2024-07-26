<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\SaleChat;
use App\Models\Company;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Sale;
use Inertia\Inertia;
use Auth;
use Carbon\Carbon;
use Session;
class SaleChatRoomController extends Controller
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
    public function store($name)
    {
        $chatRoom = new ChatRoom();
        $chatRoom->name = $name;
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


        return Inertia::render('Sales/ChatRoom/Show',compact('chatroom','messages','auth_member','readBy'));
    }

    public function tempshow(Enquiry $enquiry){
        return Inertia::render('Sales/ChatRoom/TempShow',compact('enquiry'));
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

    public function settings(Chatroom $chatroom){
        $members = $chatroom->members;
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
        return Inertia::render('Sales/ChatRoom/Settings',compact('chatroom','members','memberCount','employees','auth_member','product'));
    }

    public function addUser(Request $request, $id){
        $chatroom = ChatRoom::where('id',$id)->first();
        $saleChat = $chatroom->saleChats()->first();

        foreach($request->staff as $staff){
            if(SaleChat::where('user_id',$staff)->where('cas_no',$saleChat->cas_no)->exists()){
                $StaffSaleChat = SaleChat::where('user_id',$staff)->where('cas_no',$saleChat->cas_no)->first();
            }else{
                $saleChatController = new SaleChatsController();
                $StaffSaleChat = $saleChatController->store($staff,$saleChat->product_name,$saleChat->cas_no);
            }

            if(!$StaffSaleChat->chatRooms->contains($id)){
                $StaffSaleChat->chatRooms()->attach($id);
            }
            if(!$chatroom->members->contains($staff)){
                $chatroom->members()->attach($staff);
            }
        }

        Session::flash('tag','Members added sucessfully!');
    }

    public function newMessage(Request $request, $id){
        $message = new Message();
        $message->chatroom_id = $id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();

        return $message;
    }
}
