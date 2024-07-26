<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
class Message extends Model
{
    use HasFactory;

    protected $appends = ['link'];

    protected $with =['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function readBy(Chatroom $chatroom)
    {
        return $this->belongsToMany(User::class, 'read_messages')
                    ->wherePivot('chatroom_id', $chatroom->id)
                    ->withTimestamps();
    }

    public function getLinkAttribute(){
        if($this->type == 'file'){
            return env('APP_URL').'/storage/message/'.$this->chatroom_id.'/'.$this->message;
        }
    }
}
