<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\ChatRoom;
use App\Models\EnquiryChat;
use App\Models\ChatRoomMember;
use App\Models\SaleChat;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\SaleStaff;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductStaff;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Auth;
use Inertia\Inertia;
use Session;

class ChatroomController extends Controller
{
    public function newMessage(Request $request, $id)
    {
        $message = new Message();
        $message->chatroom_id = $id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();

        $chatroom = ChatRoom::find($id);
        $chatroom->message_at = Carbon::now()->toDateTimeString();
        $chatroom->save();

        $message->readBy($chatroom)->attach(Auth::user()->id, ['chatroom_id' => $chatroom->id]);

        return $message;
    }

    public function shareMessage(Request $request)
    {
        if ($request->chatrooms) {
            foreach ($request->chatrooms as $chatroom) {
                $message = new Message();
                $message->chatroom_id = $chatroom;
                $message->user_id = Auth::user()->id;
                $message->message = $request->message;

                $chatroom = ChatRoom::find($chatroom);
                $chatroom->message_at = Carbon::now()->toDateTimeString();
                $chatroom->save();

                $message->save();
            }
        }

        return;
    }

    public function fileUpload(Request $request, $id)
    {   
        
        foreach (request()->file('file') as $singleFile) {
            $fileWithExt = $singleFile->getClientOriginalName();
            $file = pathinfo($fileWithExt, PATHINFO_FILENAME);
            $extension = $singleFile->getClientOriginalExtension();
            $fileNameToStore = $this->getFileName($id, time().'-'.$file, $extension);
            // $singleFile->storeAs('message', $id . '/' . $fileNameToStore);
            
            $singleFile->move(public_path('storage/message/'.$id), $fileNameToStore);

            $message = new Message();
            $message->chatroom_id = $id;
            $message->user_id = Auth::user()->id;
            $message->message = $fileNameToStore;
            $message->type = 'file';
            $message->save();

        }

        return Inertia::location(route('enquiry.chatroom.show', [$id]));
    }

    public function getFileName($id, $file, $extension)
    {
        $name = $file . '_' . time() . '.' . $extension;
        $count = 0;

        while (Message::where('chatroom_id', $id)->where('message', $name)->exists()) {
            $count++;
            $name = $file . '_' . time() . $count . '.' . $extension;
        }

        return $name;
    }

    public function addUser(Request $request, $id)
    {
        $chatroom = ChatRoom::where('id', $id)->first();
        foreach ($request->staff as $staff) {
            if (!$chatroom->members->contains($staff)) {
                $chatroom->members()->attach($staff);
            }
        }

        Session::flash('tag', 'Members added successfully!');
    }

    public function sendMessages(Request $request)
    {
        // return $request->all();
        foreach ($request->sales as $sale) {
            $this->enquiryMessage($request->message, $sale);
        }

        foreach ($request->products as $product) {
            $this->productMessage($request->message, $product);
        }

        return;
    }

    public function createChat($user_id, $product_name, $cas_no)
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

    public function enquiryMessage($messageContent, $id)
    {
        $sale = Sale::where('id', $id)->first();

        if (Auth::user()->id == $sale->user_id) {
            Session::flash('toast', "You cann't text yourself");
            return;
        }
        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $sale->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChat = $this->createChat(Auth::user()->id, $sale->product_name, $sale->cas_no);
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
            $user = Auth::user();
            $company = Company::where('id', $user->company_id)->first();
            $chatRoomName = $sale->cas_no . ' - ' . $user->name . '@' . $company->name;

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
            if (SaleChat::where('user_id', $staff->user_id)->where('cas_no', $sale->cas_no)->exists()) {
                $saleChat = SaleChat::where('user_id', $staff->user_id)->where('cas_no', $sale->cas_no)->first();
            } else {
                $saleChatController = new SaleChatsController();
                $saleChat = $saleChatController->store($staff->user_id, $sale->product_name, $sale->cas_no);
            }

            if (!$saleChat->chatRooms->contains($chatroom->id)) {
                $saleChat->chatRooms()->attach($chatroom->id);
            }
            if (!$chatroom->members->contains($staff->user_id)) {
                $chatroom->members()->attach($staff->user_id);
            }
        }

        $message = new Message();
        $message->chatroom_id = $chatroom->id;
        $message->user_id = Auth::user()->id;
        $message->message = $messageContent;
        $message->save();

        $authUser = Auth::user();
        $saleUser = User::where('id', $sale->user_id)->first();

        if (!$authUser->contacts->contains($saleUser->id)) {
            $authUser->contacts()->attach($saleUser->id);
        }

        if (!$saleUser->contacts->contains($authUser->id)) {
            $saleUser->contacts()->attach($authUser->id);
        }

        Session::flash('toast', 'Message sent!!!');
    }

    public function productMessage($messageContent, $id)
    {
        $product = Product::where('id', $id)->first();

        $enquiryChatrooms = array();
        $saleChatrooms = array();

        if (EnquiryChat::where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->exists()) {
            $enquiryChat = EnquiryChat::with('chatRooms')->where('user_id', Auth::user()->id)->where('cas_no', $product->cas_no)->first();
            $enquiryChatrooms = $enquiryChat->chatRooms;
        } else {
            $enquiryChat = $this->createChat(Auth::user()->id, $product->product_name, $product->cas_no);
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

        if (!$chatroom) {
            $user = Auth::user();
            $company = Company::where('id', $user->company_id)->first();
            $chatRoomName = $product->cas_no . ' - ' . $user->name . '@' . $company->name;

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

        $productStaff = $product->staff;

        foreach ($productStaff as $staff) {
            if (SaleChat::where('user_id', $staff->user_id)->where('cas_no', $product->cas_no)->exists()) {
                $saleChat = SaleChat::where('user_id', $staff->user_id)->where('cas_no', $product->cas_no)->first();
            } else {
                $saleChatController = new SaleChatsController();
                $saleChat = $saleChatController->store($staff->user_id, $product->product_name, $product->cas_no);
            }

            if (!$saleChat->chatRooms->contains($chatroom->id)) {
                $saleChat->chatRooms()->attach($chatroom->id);
            }
            if (!$chatroom->members->contains($staff->user_id)) {
                $chatroom->members()->attach($staff->user_id);
            }
        }

        $message = new Message();
        $message->chatroom_id = $chatroom->id;
        $message->user_id = Auth::user()->id;
        $message->message = $messageContent;
        $message->save();

        $authUser = Auth::user();
        $saleUser = User::where('id', $product->user_id)->first();

        if (!$authUser->contacts->contains($saleUser->id)) {
            $authUser->contacts()->attach($saleUser->id);
        }

        if (!$saleUser->contacts->contains($authUser->id)) {
            $saleUser->contacts()->attach($authUser->id);
        }

        Session::flash('toast', 'Message sent!!!');
    }


    public function deleteMessages(Request $request, ChatRoom $chatroom)
    {
        $lastMessage = $chatroom->lastMessage;
        $member = $chatroom->members()->where(['chatroom_id' => $chatroom->id, 'user_id' => $request->user])->first();
        $member->pivot->messages_deleted_till = $lastMessage->id;
        $member->pivot->save();

        Session::flash('toast', "Messages Deleted Successfully!");
    }

    public function exitGroup(Request $request, ChatRoom $chatroom)
    {
        $lastMessage = $chatroom->lastMessage;
        $member = $chatroom->members()->where(['chatroom_id' => $chatroom->id, 'user_id' => $request->user])->first();
        $member->pivot->chat_left = true;
        $member->pivot->chat_left_at = $lastMessage->id;
        $member->pivot->save();

        Session::flash('toast', "You are no Longer memeber of the group");
    }

    public function deleteChats(Request $request)
    { 
       
        if ($request->chatrooms) {
            foreach ($request->chatrooms as $chatroom) {
                
                $cRoom = ChatRoom::find($chatroom['id']);
                
                $messages = Message::where('chatroom_id', $chatroom['id'])->get();
                foreach($messages as $message) {
                    
                        if ($message->type=='file' ) {
                            $file_path = public_path('storage/message/'.$message->chatroom_id.'/' . $message->message);
                            
                            if(File::exists($file_path)) {
                                File::delete($file_path);
                            }
                            
                        }
                    
                    $message->delete();
                }

                // dd('chatRooms ',$messages);
                // $lastMessage = $cRoom->lastMessage;
                // $member = $cRoom->members()->where(['chatroom_id' => $cRoom->id, 'user_id' => Auth::user()->id])->first();
                // if ($lastMessage) {
                //     $member->pivot->messages_deleted_till = $lastMessage->id;
                //     $member->pivot->save();
                // } else {
                //     
                // }

                $cRoom->delete();

                return;
                // return redirect()->route('enquiry.chats.index');
                // Session::flash('toast', "Messages Deleted Successfully!");
            }
        }
    }

    public function deleteMessage(Message $message)
    {   
        if($message->type == 'file') {
            $filePath = public_path('storage/message/'.$message->chatroom_id.'/'.$message->message);
            
            if($message->message && File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        return $message->delete();
    }
}
