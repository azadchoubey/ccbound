<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EnquiryChat;
use App\Models\ChatRoomMember;
use App\Models\SaleChat;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\SaleStaff;
use App\Models\User;
use App\Models\Company;
use App\Models\EnquiryChatroom;
use App\Models\Message;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\File;
use Session;

class EnquiryChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EnquiryChat::query();
        $query->where('user_id', Auth::user()->id)
            ->join('enquiry_chat_chatroom', 'enquiry_chats.id', '=', 'enquiry_chat_chatroom.enquiry_chat_id')
            ->join('chat_rooms', 'enquiry_chat_chatroom.chatroom_id', '=', 'chat_rooms.id')
            ->select('enquiry_chats.*', \DB::raw('count(chat_rooms.id) as chatroom_count'))
            ->groupBy('enquiry_chats.id', 'enquiry_chats.user_id', 'enquiry_chats.product_name', 'enquiry_chats.cas_no', 'enquiry_chats.last_message_at', 'enquiry_chats.created_at', 'enquiry_chats.updated_at');


        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
            });
        }
        $chats = $query->get();

        // $chats = $query->get();
        foreach ($chats as $chat) {
            $chat->load('chatRooms');
        }

        foreach ($chats as $chat) {
            $count = 0;
            foreach ($chat->chatRooms as $chatRoom) {

                if ($chatRoom && $chatRoom->message_read == false) {

                    $count++;
                }
            }

            $chat->unread_count = $count;
        }

        $chatsArray = $chats->toArray();

        $chats = array_map(function ($chat) {
            $chat['last_message_at'] = \Carbon\Carbon::parse($chat['last_message_at']);
            return $chat;
        }, $chatsArray);


        $sortedChats = collect($chats)->sortByDesc('last_message_at')->values();

        $perPage = 15;
        $page = request()->get('page', 1);

        $paginatedChats = $sortedChats->forPage($page, $perPage);

        $chats = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedChats,
            $sortedChats->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );


        if ($request->wantsJson()) {
            return $chats;
        }
        // return $chats;
        return Inertia::render('Enquiry/Chats/Index', compact('chats'));
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
    public function store($user_id, $product_name, $cas_no)
    {
        if (EnquiryChat::where('user_id', $user_id)->where('cas_no', $cas_no)->exists()) {
            $enquiryChat = EnquiryChat::where('user_id', $user_id)->where('cas_no', $cas_no)->first();
        } else {
            $enquiryChat = new EnquiryChat();
            $enquiryChat->user_id = $user_id;
            $enquiryChat->product_name = $product_name;
            $enquiryChat->cas_no = $cas_no;
            $enquiryChat->last_message_at = Carbon::now()->toDateTimeString();
            $enquiryChat->save();
        }

        return $enquiryChat;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EnquiryChat $chat)
    {
        $chatrooms = $chat->chatRooms()->paginate();
        
        if ($request->tab === 'starred') {
            $chatrooms = $chat->starredChatRooms()->paginate();
        }

        if ($request->search) {
            if ($request->tab === 'all') {
                $chatrooms = $chat->chatRooms()->where('name', 'like', '%' . $request->search . '%')->paginate();
            } else {
                $chatrooms = $chat->starredChatRooms()->where('name', 'like', '%' . $request->search . '%')->paginate();
            }
        }

        foreach ($chatrooms as $chatroom) {
            if ($chatroom->enquiryStarred->contains($chat->id)) {
                $chatroom->starred =  True;
            } else {
                $chatroom->starred =  False;
            }

            $chatroom->members = $chatroom->members;
            $chatroom->users = $chatroom->users;
            $chatroom->auth_id = Auth::user()->id;
        }

        $chat->user = $chat->user;
        
        if ($request->wantsJson()) {
            return $chatrooms;
        }

        return Inertia::render('Enquiry/Chats/Show', compact('chat', 'chatrooms'));
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

    public function redirectToChat(Sale $sale)
    {

        if (Auth::user()->id == $sale->user_id) {
            return
                "<div style='height:100%; display:flex; justify-content:center; align-items:center;'>
            <h2>You cannot text your self</h2>
            <div>
            ";
        }
        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            return redirect(route('enquiry.chatroom.tempshow', ['sale' => $sale]));
        }

        if (SaleChat::where('user_id', $sale->user_id)->where('cas_no', $sale->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', $sale->user_id)->where('cas_no', $sale->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            return redirect(route('enquiry.chatroom.tempshow', ['sale' => $sale]));
        }

        $chatroom = false;

        foreach ($enquiryChatrooms as $enquiryChatroom) {
            foreach ($saleChatrooms as $saleChatroom) {
                if ($enquiryChatroom->chatroom_id == $saleChatroom->chatroom_id) {
                    $chatroom = $enquiryChatroom;
                    break;
                }
            }
        }

        if ($chatroom) {
            if ($chatroom->product_id != $sale->id || $chatroom->product_type != 'sales') {
                $chatroom->product_id = $sale->id;
                $chatroom->product_type = 'sales';
                $chatroom->save();
            }
            return redirect(route('enquiry.chatroom.show', ['chatroom' => $chatroom]));
        }
        return redirect(route('enquiry.chatroom.tempshow', ['sale' => $sale]));
    }

    public function createNew(Request $request)
    {
        $sale = Sale::where('id', $request->sale['id'])->first();

        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChat = $this->store(Auth::user()->id, $sale->product_name, $sale->cas_no);
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

        // if (!$chatroom) {
        //     $user = Auth::user();
        //     $company = Company::where('id', $user->company_id)->first();
        //     $chatRoomName = $sale->product_name . '- ' . $sale->cas_no . ' - ' . $user->name . '@' . $company->name;

        //     $chatRoomController = new EnquiryChatroomController();
        //     $chatroom = $chatRoomController->store($chatRoomName, $sale->id, 'sales');
        // }

        if (!$chatroom) {
            $user = Auth::user();

            $saleUser = User::where('id', $sale->user_id)->first();

            $chatRoomName = $sale->product_name . '- ' . $sale->cas_no . ' - Initiated By ' . $user->name . ' - Posted By ' . $saleUser->name;

            $chatRoomController = new EnquiryChatroomController();
            $chatroom = $chatRoomController->store($chatRoomName, $sale->id, 'sales');
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

        if (!$chatroom->members->contains($sale->user_id)) {
            $chatroom->members()->attach($sale->user_id);
            // $chatroom->members()->attach($sale->user_id,['is_admin'=>1]);
        }

        $saleStaff = $sale->staff;

        foreach ($saleStaff as $staff) {
            if (SaleChat::where('user_id', $staff->id)->where('cas_no', $sale->cas_no)->exists()) {
                $saleChat = SaleChat::where('user_id', $staff->user_id)->where('cas_no', $sale->cas_no)->first();
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
        $message->message = $request->message;
        $message->save();

        $authUser = Auth::user();
        $saleUser = User::where('id', $sale->user_id)->first();

        if (!$authUser->contacts->contains($saleUser->id)) {
            $authUser->contacts()->attach($saleUser->id);
        }

        if (!$saleUser->contacts->contains($authUser->id)) {
            $saleUser->contacts()->attach($authUser->id);
        }

        return redirect(route('enquiry.chatroom.show', ['chatroom' => $chatroom]));
    }

    public function star(Request $request, EnquiryChat $chat)
    {
        if ($chat->starredChatRooms->contains($request->chatroom)) {
            $chat->starredChatRooms()->detach($request->chatroom);
        } else {
            $chat->starredChatRooms()->attach($request->chatroom);
        }
    }

    public function deleteChat($id)
    {
        $enquiryChat = EnquiryChat::find($id);
        $enquiryChatRooms = EnquiryChatroom::where('enquiry_chat_id', $id)->get();
        
        foreach ($enquiryChatRooms as $enquiryChatRoom) {

            $chatRoom = ChatRoom::where('id', $enquiryChatRoom->chatroom_id)->first();
            $messages = Message::where('chatroom_id', $enquiryChatRoom->chatroom_id)->get();

            foreach ($messages as $message) {
                if ($message->type == 'file') {
                    $filePath = public_path('storage/message/' . $message->chatroom_id . '/' . $message->message);

                    if ($message->message && File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
                $message->delete();
            }

            $chatRoom->delete();
            $enquiryChatRoom->delete();
            $enquiryChat->delete();

        }

        Session::flash('toast', "Chat Deleted Sucessfully!");

    }
}
