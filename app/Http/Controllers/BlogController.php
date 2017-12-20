<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with(['author', 'tags'])->paginate(5);
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $post = Post::with('tags')->whereSlug($slug)->first();
        $tags = Tag::all();

        return view('blog.show', compact('post', 'tags'));
    }

    /**
     * Display a listing of the resource based on a tag.
     *
     * @param $slug
     *
     * @return \Illuminate\View\View
     */
    public function tag($slug)
    {
        $tag = Tag::whereSlug($slug)->first();
        $posts = $tag->posts()->with(['author', 'tags'])->paginate(5);
        $tags = Tag::all();

        return view('blog.tag', compact('tag', 'posts', 'tags'));
    }
}
