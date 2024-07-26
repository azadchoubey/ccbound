<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EnquiryChat;
use App\Models\ChatRoomMember;
use App\Models\SaleChat;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleStaff;
use App\Models\ProductStaff;
use App\Models\User;
use App\Models\Company;
use App\Models\Message;
use Carbon\Carbon;
use Auth;

class ProductChatsController extends Controller
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
    public function destroy($id)
    {
        //
    }

    public function redirectToChat(Product $product)
    {

        if (Auth::user()->id == $product->user_id) {
            return
                "<div style='height:100%; display:flex; justify-content:center; align-items:center;'>
            <h2 style=''>You cannot text your self</h2>
            <div>
            ";
        }
        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            return redirect(route('product.chatroom.tempshow', ['product' => $product]));
        }

        if (SaleChat::where('user_id', $product->user_id)->where('cas_no', $product->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', $product->user_id)->where('cas_no', $product->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            return redirect(route('product.chatroom.tempshow', ['product' => $product]));
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
            if ($chatroom->product_id != $product->id || $chatroom->product_type != 'product') {
                $chatroom->product_id = $product->id;
                $chatroom->product_type = 'product';
                $chatroom->save();
            }
            return redirect(route('enquiry.chatroom.show', ['chatroom' => $chatroom]));
        }
        return redirect(route('product.chatroom.tempshow', ['product' => $product]));
    }

    public function createNew(Request $request)
    {
        $product = Product::where('id', $request->product['id'])->first();

        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChat = $this->store(Auth::user()->id, $product->product_name, $product->cas_no);
        }

        if (SaleChat::where('user_id', $product->user_id)->where('cas_no', $product->cas_no)->exists()) {
            $saleChat = SaleChat::with('chatRooms')->where('user_id', $product->user_id)->where('cas_no', $product->cas_no)->first();
            $saleChatrooms = $saleChat->chatRooms;
        } else {
            $saleChatController = new SaleChatsController();
            $saleChat = $saleChatController->store($product->user_id, $product->product_name, $product->cas_no);
        }

        $chatroom = false;

        foreach ($enquiryChatrooms as $enquiryChatroom) {
            foreach ($saleChatrooms as $saleChatroom) {
                if ($enquiryChatroom->chatroom_id == $saleChatroom->chatroom_id) {
                    $chatroom = $enquiryChatroom;
                    if ($chatroom->product_id != $product->id || $chatroom->product_type != 'product') {
                        $chatroom->product_id = $product->id;
                        $chatroom->product_type = 'product';
                        $chatroom->save();
                    }
                    break;
                }
            }
        }

        // if (!$chatroom) {
        //     $user = Auth::user();
        //     $company = Company::where('id', $user->company_id)->first();
        //     $chatRoomName = $product->product_name . '-' . $product->cas_no . ' - ' . $user->name . '@' . $company->name;

        //     $chatRoomController = new EnquiryChatroomController();
        //     $chatroom = $chatRoomController->store($chatRoomName, $product->id, 'product');
        // }

        if (!$chatroom) {
            $user = Auth::user();

            $productUser = User::where('id', $product->user_id)->first();

            $chatRoomName = $product->product_name . '-' . $product->cas_no . ' - Initiated By ' . $user->name . '- Posted By ' . $productUser->name;

            $chatRoomController = new EnquiryChatroomController();
            $chatroom = $chatRoomController->store($chatRoomName, $product->id, 'product');
        }

        if (!$enquiryChat->chatRooms->contains($chatroom->id)) {
            $enquiryChat->chatRooms()->attach($chatroom->id);
        }

        if (!$saleChat->chatRooms->contains($chatroom->id)) {
            $saleChat->chatRooms()->attach($chatroom->id);
        }

        if (!$chatroom->members->contains(Auth::user()->id)) {
            // $chatroom->members()->attach(Auth::user()->id,['is_admin'=>1]);
            $chatroom->members()->attach(Auth::user()->id);
        }

        if (!$chatroom->members->contains($product->user_id)) {
            // $chatroom->members()->attach($product->user_id,['is_admin'=>1]);
            $chatroom->members()->attach($product->user_id);
        }

        // $productStaff = ProductStaff::where('product_id',$product->id)->get();
        $productStaff = $product->staff;

        foreach ($productStaff as $staff) {
            if (SaleChat::where('user_id', $staff->id)->where('cas_no', $product->cas_no)->exists()) {
                $saleChat = SaleChat::where('user_id', $staff->id)->where('cas_no', $product->cas_no)->first();
            } else {
                $saleChatController = new SaleChatsController();
                $saleChat = $saleChatController->store($staff->id, $product->product_name, $product->cas_no);
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
        $saleUser = User::where('id', $product->user_id)->first();

        if (!$authUser->contacts->contains($saleUser->id)) {
            $authUser->contacts()->attach($saleUser->id);
        }

        if (!$saleUser->contacts->contains($authUser->id)) {
            $saleUser->contacts()->attach($authUser->id);
        }


        return redirect(route('enquiry.chatroom.show', ['chatroom' => $chatroom]));
    }
}
