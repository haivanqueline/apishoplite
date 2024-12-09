<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $feedbacks
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback đã được gửi thành công',
            'data' => $feedback
        ], 201);
    }

    public function show(Feedback $feedback)
    {
        return response()->json([
            'status' => 'success',
            'data' => $feedback
        ]);
    }

    public function updateStatus(Feedback $feedback, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,read,responded'
        ]);

        $feedback->update(['status' => $validated['status']]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật trạng thái feedback',
            'data' => $feedback
        ]);
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa feedback thành công'
        ]);
    }
}