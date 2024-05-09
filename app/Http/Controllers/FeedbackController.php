<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\PostTranslation;
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

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'string'
        ]);

        $feedback = Feedback::where('id', $request->id)->first();

        $feedback->first_name = $request->first_name;
        $feedback->last_name = $request->last_name;
        $feedback->email = $request->email;
        $feedback->comment = $request->comment;

        $feedback->save();

        return response()->json([
            'success' => true,
            'message' => 'Feedback updated'
        ]);
    }

    public function delete(Request $request)
    {
        $feedback = Feedback::where('id', $request->id)->first();

        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback deleted'
        ]);
    }
}
