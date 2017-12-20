<?php

namespace Tests\Feature\Controllers\Auth;

use App\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /** @test */
    public function it_can_log_an_user_in()
    {
        $credentials = [
            'email' => 'jbonva@gmail.com',
            'password' => '123456',
        ];
        factory(User::class)->create($credentials);

        $this->get('/login')
            ->type($credentials['email'], 'email')
            ->type($credentials['password'], 'password')
            ->press('Sign In')
            ->seePageIs('/admin');
    }

    /** @test */
    public function it_cannot_log_an_user_in_with_bad_credentials()
    {
        $credentials = [
            'email' => 'badguy@tyloo.fr',
            'password' => '123456',
        ];

        $this->get('/login')
            ->type($credentials['email'], 'email')
            ->type($credentials['password'], 'password')
            ->press('Sign In')
            ->seePageIs('/login');
    }
}
