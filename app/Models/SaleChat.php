<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ChatRoom;

class SaleChat extends Model
{
    use HasFactory;

    protected $appends = [
        'last_message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'sale_chat_chatroom', 'sale_chat_id', 'chatroom_id');
    }

    public function starredChatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'salechat_chatroom_starred', 'salechat_id', 'chatroom_id');
    }


    public function getLastMessageAttribute()
    {
        return $this->chatRooms->max('message_at');
    }
}
