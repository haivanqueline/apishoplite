<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'content' => $request->content,
                'status' => 'sent'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Message sent successfully',
                'data' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMessages(Request $request)
    {
        try {
            $messages = Message::where(function($query) use ($request) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $request->user_id);
            })->orWhere(function($query) use ($request) {
                $query->where('sender_id', $request->user_id)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

            return response()->json([
                'status' => true,
                'data' => $messages
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteMessage($id)
    {
        try {
            $message = Message::where('id', $id)
                            ->where('sender_id', Auth::id())
                            ->first();

            if (!$message) {
                return response()->json([
                    'status' => false,
                    'message' => 'Message not found or unauthorized'
                ], 404);
            }

            $message->delete();

            return response()->json([
                'status' => true,
                'message' => 'Message deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete message',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}