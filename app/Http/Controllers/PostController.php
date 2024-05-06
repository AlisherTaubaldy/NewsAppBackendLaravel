<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Post;
use App\Models\PostTranslation;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get(Request $request){

        $lang_code = app()->getLocale();

        $language = Language::where('code', $lang_code)->first();

        $posts = PostTranslation::where('lang_id', $language->id)->get();

        return response()->json($posts);
    }

    public function create(Request $request){

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|string',
            'link' => 'required|string',
            'seo_title' => 'required|string|max:250',
            'seo_description' => 'required|string|max:250',
            'seo_keywords' => 'required|string|max:250'
        ]);

        $lang_code = $request->code;

        $language = Language::where('code', $lang_code)->first();

        if (is_null($request->post_id)){
            $post = Post::create(['status' => true]);
        } else{
            $post = Post::where('id', $request->post_id)->first();
        }

        $check_post = PostTranslation::where('post_id', $request->post_id)
            ->where('lang_id', $language->id)->first();

        if (is_null($check_post)){
            $post->translations()->create([
                'lang_id' => $language->id,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $request->image_url,
                'link' => $request->link,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords
            ]);

            return $post;
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to add post to this language.',
        ], 401);
    }

    public function update(Request $request)
    {
        $post_translation = PostTranslation::where('post_id', $request->post_id)
            ->where('lang_id', $request->lang_id)->first();

        $post_translation->title = $request->title;
        $post_translation->description = $request->description;
        $post_translation->image_url = $request->image_url;
        $post_translation->link = $request->link;
        $post_translation->seo_title = $request->seo_title;
        $post_translation->seo_description = $request->seo_description;
        $post_translation->seo_keywords = $request->seo_keywords;

        $post_translation->save();
    }

    public function delete(Request $request)
    {
        echo $request->post_id;
        $post_translation = PostTranslation::where('post_id', $request->post_id)
            ->where('lang_id', $request->lang_id)->first();

        $post_translation->delete();
    }
}
