<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PublicPostController extends Controller
{
    public function index()
    {
        $posts = Post::where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}