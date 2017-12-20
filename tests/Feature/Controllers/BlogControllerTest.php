<?php

namespace Tests\Feature\Controllers;

use App\Post;
use App\Tag;
use App\User;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    /** @test */
    public function it_has_an_index_page_listing_blog_posts()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create(['author_id' => $user->id]);
        $tag = factory(Tag::class)->create();
        $tag->posts()->sync($posts);

        $this->get('/blog');
        $this->assertViewHas('posts');
    }

    /** @test */
    public function it_has_a_page_showing_a_single_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['author_id' => $user->id]);
        $this->get('/blog/'.$post->slug);
        $this->assertViewHas('post');
    }

    /** @test */
    public function it_has_a_page_listing_posts_from_a_tag()
    {
        $tag = factory(Tag::class)->create();
        $this->get('/blog/tag/'.$tag->slug);
        $this->assertViewHas('posts');
    }
}
