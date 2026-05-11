<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function chatList(Request $request)
    {
        $myId = $request->user()->id;

        $messages = Message::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->with(['sender.profile', 'receiver.profile'])
            ->latest()
            ->get()
            ->groupBy(fn($m) => $m->sender_id === $myId ? $m->receiver_id : $m->sender_id)
            ->map(fn($group) => $group->first())
            ->values();

        return response()->json($messages);
    }

    public function conversation(Request $request, User $user)
    {
        $myId = $request->user()->id;

        $messages = Message::where(fn($q) =>
                $q->where('sender_id', $myId)->where('receiver_id', $user->id))
            ->orWhere(fn($q) =>
                $q->where('sender_id', $user->id)->where('receiver_id', $myId))
            ->with(['sender.profile', 'receiver.profile'])
            ->oldest()
            ->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $myId)
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json($messages);
    }

    public function send(Request $request, User $user)
    {
        $request->validate(['body' => 'required|string|max:5000']);

        $message = Message::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $user->id,
            'body'        => $request->body,
        ]);

        return response()->json(
            $message->load(['sender.profile', 'receiver.profile']), 201
        );
    }
}