<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\EnquiryChat;
use App\Models\SaleChat;
use App\Models\Message;
use Auth;
class ChatRoom extends Model
{
    use HasFactory;

    protected $appends = [
        'message_read'
    ];

    protected $with = [
        'lastMessage'
    ];

    public function enquiryChats(){
        return $this->belongsToMany(EnquiryChat::class,'enquiry_chat_chatroom','chatroom_id','enquiry_chat_id');
    }

    public function saleChats(){
        return $this->belongsToMany(SaleChat::class,'sale_chat_chatroom','chatroom_id','sale_chat_id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'chatroom_id','id');
    }

    public function lastMessage(){
        return $this->hasOne(Message::class,'chatroom_id','id')->latestOfMany();
    }

    public function getMessageReadAttribute() {
        $lastMessage = $this->lastMessage;
        if(DB::table('read_messages')->where('user_id',Auth::user()->id)->where('message_id',$lastMessage?->id)->count() > 0){
            return True;
        }else{
            return False;
        }
    }

    public function members(){
        return $this->belongsToMany(User::class,'chatroom_member','chatroom_id','user_id')->withPivot('chat_left', 'messages_deleted_till','chat_left_at');
    }

    public function enquiryStarred(){
        return $this->belongsToMany(EnquiryChat::class,'enquirychat_chatroom_starred','chatroom_id','enquirychat_id');
    }

    public function saleStarred(){
        return $this->belongsToMany(SaleChat::class,'salechat_chatroom_starred','chatroom_id','salechat_id');
    }

    // public function members(){
    //     return $this->belongsToMany(User::class,'chatroom_member','chatroom_id','user_id')->withPivot(['is_admin']);
    // }
}
