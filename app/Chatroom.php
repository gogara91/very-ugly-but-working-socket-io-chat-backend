<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    public function messages()
    {
        return $this->hasMany(ChatroomMessage::class);
    }
}
