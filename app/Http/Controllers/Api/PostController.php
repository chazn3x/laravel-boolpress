<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::where('published', true)->with(['category', 'tags'])->get();

        return response()->json($posts);
    }

    public function show($slug) {

        $post = Post::where('slug', $slug)->with(['category', 'tags', 'comments' => fn($query) => $query->where('approved', true)])->first();

        if ( empty($post) ) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);

    }
}
