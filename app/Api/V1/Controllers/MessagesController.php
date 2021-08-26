<?php

namespace App\Api\V1\Controllers;
use App\Chatroom;
use App\ChatroomMember;
use App\ChatroomMessage;
use App\Events\ChatroomMessageEvent;
use App\Events\MessageReceived;
use App\Events\ChatroomCreated;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function index()
    {
        return Chatroom::with(['messages.user'])->first();
    }

    public function store(Request $request)
    {
        $message = ChatroomMessage::create([
            'content' => $request->input('message'),
            'user_id' => auth()->user()->id,
            'chatroom_id' => 1,
        ]);
        event(new MessageReceived($message));
        return $message;
    }

    public function createChatroom(Request $request)
    {
        $chatroom = Chatroom::create([]);

        ChatroomMember::create([
            'user_id' => auth()->user()->id,
            'chatroom_id' => $chatroom->id,
        ]);
        ChatroomMember::create([
            'user_id' => $request->input('user_id'),
            'chatroom_id' => $chatroom->id,
        ]);
        return $chatroom;
    }

    public function chatroomMessage($id, Request $request)
    {
        event(new ChatroomMessageEvent($id, $request->input('message')));
    }

    public function chatrooms()
    {
        $userId = auth()->user()->id;
        return DB::table('chatrooms')->join(
            'chatroom_members',
            'chatroom_members.chatroom_id',
            '=',
            'chatrooms.id',
            'INNER'
        )
            ->where('user_id', '=', $userId)
            ->get(['chatrooms.id']);
    }
}
