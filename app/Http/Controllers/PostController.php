<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Language;
use App\Models\Post;
use App\Models\PostTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function get(Request $request)
    {
        $language = app()->getLocale();

        $posts = Cache::remember('posts:' . $language, 60*60, function () use ($language){
            return PostTranslation::where('lang', $language)->get();
        });

        return response()->json($posts);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|string',
            'link' => 'required|string',
            'seo_title' => 'required|string|max:250',
            'seo_description' => 'required|string|max:250',
            'seo_keywords' => 'required|string|max:250'
        ]);

        $language = app()->getLocale();

        if (is_null($request->post_id)){
            $post = Post::create(['status' => true]);
        } else{
            $post = Post::where('id', $request->post_id)->first();
        }

        $check_post = PostTranslation::where('post_id', $request->post_id)
            ->where('lang', $language)->first();

        if (is_null($check_post)){
            $post->translations()->create([
                'lang' => $language,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $request->image_url,
                'link' => $request->link,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords
            ]);

            $posts = PostTranslation::where('lang', $language)->get();

            Cache::put('posts:' . $language, $posts, 60*60);

            return $post;
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to add post to this language.',
        ], 401);
    }

    public function update(Request $request)
    {
        $language = app()->getLocale();

        $post_translation = PostTranslation::where('post_id', $request->post_id)
            ->where('lang', $language)->first();

        $post_translation->title = $request->title;
        $post_translation->description = $request->description;
        $post_translation->image_url = $request->image_url;
        $post_translation->link = $request->link;
        $post_translation->seo_title = $request->seo_title;
        $post_translation->seo_description = $request->seo_description;
        $post_translation->seo_keywords = $request->seo_keywords;

        $posts = PostTranslation::where('lang', $language)->get();

        Cache::put('posts:' . $language, $posts, 60*60);

        $post_translation->save();
    }

    public function delete(Request $request)
    {
        $language = app()->getLocale();

        $post_translation = PostTranslation::where('post_id', $request->post_id)
            ->where('lang', $language)->first();

        if(!is_null($post_translation)){
            $post_translation->delete();

            $posts = PostTranslation::where('lang', $language)->get();

            Cache::put('posts:' . $language, $posts, 60*60);

            return response()->json([
                'success' => true,
                'message' => 'success',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'There is no such post.',
            ], 401);
        }
    }
}
