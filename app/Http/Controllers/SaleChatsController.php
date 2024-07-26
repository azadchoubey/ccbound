<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\ChatRoomMember;
use App\Models\SaleChat;
use App\Models\Enquiry;
use App\Models\EnquiryStaff;
use App\Models\EnquiryChat;
use App\Models\Sale;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;
use Auth;

class SaleChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SaleChat::query();
        $query->where('user_id', Auth::user()->id)
            ->join('sale_chat_chatroom', 'sale_chats.id', '=', 'sale_chat_chatroom.sale_chat_id')
            ->join('chat_rooms', 'sale_chat_chatroom.chatroom_id', '=', 'chat_rooms.id')
            ->select('sale_chats.*', \DB::raw('count(chat_rooms.id) as chat_rooms_count'))
            ->groupBy('sale_chats.id', 'sale_chats.user_id', 'sale_chats.product_name', 'sale_chats.cas_no', 'sale_chats.last_message_at', 'sale_chats.created_at', 'sale_chats.updated_at');

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('cas_no', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', '%' . $request->search . '%');
            });
        }

        $chats = $query->get();
        foreach ($chats as $chat) {
            $chat->load('chatRooms');
        }

        foreach ($chats as $chat) {
            $count = 0;
            foreach ($chat->chatRooms as $chatRoom) {
                if ($chatRoom->message_read == false) {
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


        $sortedChats = collect($chats)->sortByDesc('last_message')->values();

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

        // dd($chats->toArray());


        if ($request->wantsJson()) {
            return $chats;
        }
        return Inertia::render('Sales/Chats/Index', compact('chats'));
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
        if (SaleChat::where('user_id', $user_id)->where('cas_no', $cas_no)->exists()) {
            $enquiryChat = SaleChat::where('user_id', $user_id)->where('cas_no', $cas_no)->first();
        } else {
            $saleChat = new SaleChat();
            $saleChat->user_id = $user_id;
            $saleChat->product_name = $product_name;
            $saleChat->cas_no = $cas_no;
            $saleChat->last_message_at = Carbon::now()->toDateTimeString();
            $saleChat->save();
        }

        return $saleChat;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SaleChat $chat)
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
            if ($chatroom->saleStarred->contains($chat->id)) {
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

        return Inertia::render('Sales/Chats/Show', compact('chat', 'chatrooms'));
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

    public function redirectToChat(Enquiry $enquiry)
    {
        if (Auth::user()->id == $enquiry->user_id) {
            return
                "<div style='height:100%; display:flex; justify-content:center; align-items:center;'>
            <h2 style=''>You cannot text your self</h2>
            <div>
            ";
        }
        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            return redirect(route('sale.chatroom.tempshow', ['enquiry' => $enquiry]));
        }

        if (SaleChat::where('user_id', Auth::user()->id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $enquiry->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            return redirect(route('sale.chatroom.tempshow', ['enquiry' => $enquiry]));
        }

        $chatroom = false;

        foreach ($enquiryChatrooms as $enquiryChatroom) {
            foreach ($saleChatrooms as $saleChatroom) {
                echo $enquiryChatroom->chatroom_id . ' - ' . $saleChatroom->chatroom_id . '<br>';
                if ($enquiryChatroom->chatroom_id == $saleChatroom->chatroom_id) {
                    $chatroom = $enquiryChatroom;
                    break;
                }
            }
        }

        if ($chatroom) {
            if ($chatroom->product_id != $enquiry->id || $chatroom->product_type != 'enquiry') {
                $chatroom->product_id = $enquiry->id;
                $chatroom->product_type = 'enquiry';
                $chatroom->save();
            }
            return redirect(route('sale.chatroom.show', ['chatroom' => $chatroom]));
        }
        return redirect(route('sale.chatroom.tempshow', ['enquiry' => $enquiry]));
    }

    public function createNew(Request $request)
    {
        $enquiry = Enquiry::where('id', $request->enquiry['id'])->first();

        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', $enquiry->user_id)->where('cas_no', $enquiry->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChatController = new EnquiryChatsController();
            $enquiryChat = $enquiryChatController->store($enquiry->user_id, $enquiry->product_name, $enquiry->cas_no);
        }

        if (SaleChat::where('user_id', Auth::user()->id)->where('cas_no', $enquiry->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $enquiry->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            $saleChat = $this->store(Auth::user()->id, $enquiry->product_name, $enquiry->cas_no);
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

        // if (!$chatroom) {
        //     $user = User::where('id', $enquiry->user_id)->first();
        //     $company = Company::where('id', $user->company_id)->first();
        //     $chatRoomName = $enquiry->product_name . '-' . $enquiry->cas_no . ' - ' . $user->name . '@' . $company->name;

        //     $chatRoomController = new EnquiryChatroomController();
        //     $chatroom = $chatRoomController->store($chatRoomName, $enquiry->id, 'enquiry');
        // }

        if (!$chatroom) {
            $user = Auth::user();

            $enquiryUser = User::where('id', $enquiry->user_id)->first();

            $chatRoomName = $enquiry->product_name . '-' . $enquiry->cas_no . ' - Initiated By ' . $user->name . '- Posted By ' . $enquiryUser->name;

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

        if (!$chatroom->members->contains($enquiry->user_id)) {
            $chatroom->members()->attach($enquiry->user_id);
            // $chatroom->members()->attach($enquiry->user_id,['is_admin'=>1]);
        }

        // $enquiryStaff = EnquiryStaff::where('enquiry_id',$enquiry->id)->get();
        $enquiryStaff = $enquiry->staff;

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
        $message->message = $request->message;
        $message->save();

        $authUser = Auth::user();
        $enquiryUser = User::where('id', $enquiry->user_id)->first();

        if (!$authUser->contacts->contains($enquiryUser->id)) {
            $authUser->contacts()->attach($enquiryUser->id);
        }

        if (!$enquiryUser->contacts->contains($authUser->id)) {
            $enquiryUser->contacts()->attach($authUser->id);
        }

        return redirect(route('enquiry.chatroom.show', ['chatroom' => $chatroom]));
    }

    public function star(Request $request, SaleChat $chat)
    {
        if ($chat->starredChatRooms->contains($request->chatroom)) {
            $chat->starredChatRooms()->detach($request->chatroom);
        } else {
            $chat->starredChatRooms()->attach($request->chatroom);
        }
    }

    public function deleteChat($id) {
        dd($id);
    }
}
