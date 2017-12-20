<?php

namespace Tests\Feature\Controllers\Admin;

use App\User;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    /** @test */
    public function it_can_visit_profile_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/admin/profile')
             ->see('Welcome');
    }
}
