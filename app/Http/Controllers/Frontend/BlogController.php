<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\Post\WithAuthor;
use App\Repositories\Criteria\Post\WithTags;
use App\Repositories\Criteria\Rememberable;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;

class BlogController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var TagRepository
     */
    protected $tag;

    public function __construct(PostRepository $post, TagRepository $tag)
    {
        $this->post = $post;
        $this->tag = $tag;

        $this->post
                   ->pushCriteria(new WithAuthor())
                   ->pushCriteria(new WithTags());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->post->paginate(10);

        return view('frontend.pages.blog.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function show($slug)
    {
        $post = $this->post->findBy('slug', $slug);

        return view('frontend.pages.blog.show', compact('post'));
    }

    /**
     * Display a listing of the resource based on a tag.
     *
     * @param $slug
     *
     * @return Response
     */
    public function tag($slug)
    {
        $tag = $this->tag->findBy('slug', $slug);
        $posts = $tag->posts()->paginate(10);

        return view('frontend.pages.blog.tag', compact('tag', 'posts'));
    }
}
