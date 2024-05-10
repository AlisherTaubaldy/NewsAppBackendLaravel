<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdatePostRequest;
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

    public function create(CreateUpdatePostRequest $request)
    {
        $request->validated();

        $language = app()->getLocale();

        echo $language;

        if (is_null($request->post_id)){//if null will create new post
            $post = Post::create(['status' => true]);
        } else{//if is not null will find it
            $post = Post::where('id', $request->post_id)->first();
        }

        $check_post = PostTranslation::where('post_id', $post->id)
            ->where('lang', $language)->first();

        if (is_null($check_post)){
            $postTranlation = new PostTranslation();

            $postTranlation->post_id = $post->id;
            $postTranlation->lang = $language;
            $postTranlation->title = $request->input('title');
            $postTranlation->description = $request->input('description');
            $postTranlation->image_url = $request->input('image_url');
            $postTranlation->link = $request->input('link');
            $postTranlation->seo_title = $request->input('seo_title');
            $postTranlation->seo_description = $request->input('seo_description');
            $postTranlation->seo_keywords = $request->input('seo_keywords');
//            PostTranslation::create([
//                'post_id' => $post->id,
//                'lang' => $language,
//                'title' => $request->input('title'),
//                'description' => $request->input('description'),
//                'image_url' => $request->input('image_url'),
//                'link' => $request->input('link'),
//                'seo_title' => $request->input('seo_title'),
//                'seo_description' => $request->input('seo_description'),
//                'seo_keywords' => $request->input('seo_keywords'),
//            ]);
            $postTranlation->save();

            $posts = PostTranslation::where('lang', $language)->get();

            Cache::put('posts:' . $language, $posts, 60*60);

            return $postTranlation;
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to add post to this language.',
        ], 401);
    }

    public function update(CreateUpdatePostRequest $request)
    {
        $request->validated();

        $language = app()->getLocale();

        $post_translation = PostTranslation::where('post_id', $request->post_id)
            ->where('lang', $language)->first();

        if($request->has('title'))

        $post_translation->title = $request->input('title');
        $post_translation->description = $request->input('description');
        $post_translation->image_url = $request->input('image_url');
        $post_translation->link = $request->input('link');
        $post_translation->seo_title = $request->input('seo_title');
        $post_translation->seo_description = $request->input('seo_description');
        $post_translation->seo_keywords = $request->input('seo_keywords');

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
