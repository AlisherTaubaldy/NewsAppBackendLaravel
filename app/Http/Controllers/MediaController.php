<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function get()
    {
        return Media::all();
    }

    public function store(CreateUpdateMediaRequest $request)
    {
        $request->validated();

        Media::create([
            'video_title' => $request->input('video_title'),
            'video_url' => $request->input('video_url'),
            'video_preview' => $request->input('video_preview'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Media added successfully'
        ]);
    }

    public function update(CreateUpdateMediaRequest $request)
    {
        $request->validated();

        $media = Media::where('id', $request->id)->first();

        $media->video_title = $request->input('video_title');
        $media->video_url = $request->input('video_url');
        $media->video_preview = $request->input('video_preview');;

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
