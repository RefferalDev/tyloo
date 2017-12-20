<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    /** @test */
    public function it_can_edit_settings()
    {
        $this->createAndBe();

        $this->get('/admin/settings');
    }

    /** @test */
    public function it_can_update_settings()
    {
        $this->createAndBe();

        $this->put('/admin/settings')->see('OK');
        $this->assertResponseOk();
    }
}
