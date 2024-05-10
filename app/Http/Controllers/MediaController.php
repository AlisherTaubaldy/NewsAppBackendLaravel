<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function get()
    {
        return Media::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_title' => 'required|string',
            'video_url' => ['required', 'string', 'regex:/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?.*v=|embed\/)([\w-]+)$/'],
            'video_preview' => 'required|string'
        ]);

        Media::create([
            'video_title' => $request->video_title,
            'video_url' => $request->video_url,
            'video_preview' => $request->video_preview,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Media added successfully'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'video_title' => 'required|string',
            'video_url' => ['required', 'string'],
            'video_preview' => 'required|string'
        ]);

        $media = Media::where('id', $request->id)->first();

        $media->video_title = $request->video_title;
        $media->video_url = $request->video_url;
        $media->video_preview = $request->video_preview;

        $media->save();

        return response()->json([
            'success' => true,
            'message' => 'Media updated'
        ]);
    }

    public function delete(Request $request)
    {
        $media = Media::where('id', $request->id)->first();

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted'
        ]);
    }
}
