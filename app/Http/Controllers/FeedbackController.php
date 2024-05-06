<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function get()
    {
        return Feedback::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'string'
        ]);

        $feedback = Feedback::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'comment' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfull.',
        ], 200);
    }
}
