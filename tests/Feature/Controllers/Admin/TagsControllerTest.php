<?php

namespace Tests\Feature\Controllers\Admin;

use App\Tag;
use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    /** @test */
    public function it_can_fetch_tags_list()
    {
        $this->createAndBe();

        $this->get('/admin/tags');
    }

    /** @test */
    public function it_can_create_a_tag()
    {
        $this->createAndBe();

        $this->get('/admin/tags/create');
    }

    /** @test */
    public function it_can_store_a_tag()
    {
        $this->createAndBe();

        $data = [
            'name' => 'Tag Name',
            'slug' => 'tag-name',
        ];

        $this->post('/admin/tags', $data);
        $this->seeInDatabase('tags', $data);
        $this->assertRedirectedToRoute('admin.tags.index');
    }

    /** @test */
    public function it_has_a_page_showing_a_tag()
    {
        $this->createAndBe();

        $tag = factory(Tag::class)->create();
        $this->get('/admin/tags/'.$tag->id);
        $this->assertViewHas('tag');
    }

    /** @test */
    public function it_can_edit_a_tag()
    {
        $this->createAndBe();

        $tag = factory(Tag::class)->create();
        $this->get('/admin/tags/'.$tag->id.'/edit');
        $this->assertViewHas('tag');
    }

    /** @test */
    public function it_can_update_a_tag()
    {
        $this->createAndBe();

        $data = ['name' => 'New Name'];
        $tag = factory(Tag::class)->create();

        $this->put('/admin/tags/'.$tag->id, $data);
        $this->seeInDatabase('tags', $data);
        $this->assertRedirectedToRoute('admin.tags.index');
    }

    /** @test */
    public function it_can_delete_a_tag()
    {
        $this->createAndBe();

        $data = [
            'name' => 'Tag Name',
            'slug' => 'tag-name',
        ];
        $tag = factory(Tag::class)->create($data);

        $this->get('/admin/tags/delete/'.$tag->id);
        $this->notSeeInDatabase('tags', $data);
        $this->assertRedirectedToRoute('admin.tags.index');
    }
}
