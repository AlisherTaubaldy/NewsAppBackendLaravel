<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Creating success'
        ]);
    }

    public function get(){
        return Faq::all();
    }

    public function delete(Request $request)
    {
        $faq = Faq::where('id', $request->id)->first();

        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted success'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        $faq = Faq::where('id', $request->id)->first();

        $faq->question  = $request->question;
        $faq->answer = $request->answer;

        $faq->save();

        return response()->json([
            'success' => true,
            'message' => 'Updating success'
        ]);
    }

}
