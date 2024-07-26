<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EnquiryMessages;
class EnquiryChatroom extends Model
{
    use HasFactory;

    protected $table = 'enquiry_chat_chatroom';
    
    public function chats() {
        return $this->belongsToMany(EnquiryChat::class,'enquiry_chat_enquiry_chatroom','chatroom_id','enquiry_chat_id');
    }

    public function messages(){
        return $this->hasMany(EnquiryMessages::class,'chatroom_id','id');
    }
}
