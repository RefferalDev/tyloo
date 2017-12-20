<?php

namespace Tests\Feature\Controllers\Admin;

use App\User;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    /** @test */
    public function it_cannot_visit_dashboard_when_anonymous()
    {
        $this->get('/admin')
             ->seePageIs('/admin/auth/login');
    }

    /** @test */
    public function it_can_visit_dashboard_when_connected()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/admin');
    }
}
