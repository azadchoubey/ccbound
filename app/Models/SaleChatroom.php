<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleChatroom extends Model
{
    use HasFactory;
    protected $table = 'sale_chat_chatroom';
    protected $primaryKey = 'sale_chat_id';
    
    public function chats() {
        return $this->belongsToMany(SaleChat::class,'sale_chat_chatroom','chatroom_id','sale_chat_id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'chatroom_id','id');
    }
}
