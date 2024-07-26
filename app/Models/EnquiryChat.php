<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\EnquiryChatRoom;

class EnquiryChat extends Model
{
    use HasFactory;

    protected $appends = [
        'last_message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chatRooms(){
        return $this->belongsToMany(ChatRoom::class,'enquiry_chat_chatroom','enquiry_chat_id','chatroom_id');
    }

    public function starredChatRooms(){
        return $this->belongsToMany(ChatRoom::class,'enquirychat_chatroom_starred','enquirychat_id','chatroom_id');
    }

    public function getLastMessageAttribute(){
        return $this->chatRooms->max('message_at');
    }
}
