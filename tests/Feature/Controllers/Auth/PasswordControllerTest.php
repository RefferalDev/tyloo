<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;

class PasswordControllerTest extends TestCase
{
    /** @test */
    public function it_can_remind_password()
    {
        $this->get('/remind')
            ->type('test@test.com', 'email')
            ->press('Submit')
            ->seePageIs('/remind');
    }
}
