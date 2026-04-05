<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $sessionId = Session::getId();
        $userId = auth()->id();

        ChatMessage::create([
            'sender_id' => $userId,
            'session_id' => $sessionId,
            'message' => $request->message,
            'is_admin_reply' => false, // Assuming users send from frontend
        ]);

        return response()->json(['success' => true, 'message' => 'Sent']);
    }

    public function fetch()
    {
        $sessionId = Session::getId();
        $userId = auth()->id();

        $query = ChatMessage::query();

        if ($userId) {
            $query->where(function($q) use ($userId, $sessionId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId)
                  ->orWhere('session_id', $sessionId);
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'is_admin' => false // For frontend
        ]);
    }
}
