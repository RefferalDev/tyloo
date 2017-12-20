<?php

namespace Tests\Feature\Controllers;

use App\User;
use App\Work;
use Tests\TestCase;

class WorkControllerTest extends TestCase
{
    /** @test */
    public function it_loads_works_on_index_page()
    {
        $user = factory(User::class)->create();
        factory(Work::class, 10)->create(['user_id' => $user->id]);
        $this->get('/works');
        $this->assertViewHas('works');
    }

    /** @test */
    public function it_can_fetch_a_single_work_page()
    {
        $user = factory(User::class)->create();
        $work = factory(Work::class)->create(['user_id' => $user->id]);
        $this->call('GET', '/works/'.$work->slug);
        $this->assertViewHas('work');
    }
}
