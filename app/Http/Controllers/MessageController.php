<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get unique users that the current user has conversed with
        $conversations = User::whereHas('sentMessages', function ($q) use ($userId) {
            $q->where('receiver_id', $userId);
        })->orWhereHas('receivedMessages', function ($q) use ($userId) {
            $q->where('sender_id', $userId);
        })->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $currentUserId = auth()->id();

        // Mark incoming messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($currentUserId, $user) {
            $q->where('sender_id', $currentUserId)
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($currentUserId, $user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $currentUserId);
        })->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $request->message
        ]);

        return back();
    }
}
