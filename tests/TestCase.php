<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Create and Log In an User.
     */
    public function createAndBe()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        return $user;
    }
}
