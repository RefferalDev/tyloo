<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    /** @test */
    public function it_has_an_home_page()
    {
        $this->get('/');
    }

    /** @test */
    public function it_has_a_resume_page()
    {
        $this->get('/resume');
    }

    /** @test */
    public function it_has_a_contact_page()
    {
        $this->get('/contact');
    }

    /** @test */
    public function it_can_send_contact_form()
    {
        $data = [
            'name' => 'Julien Bonvarlet',
            'email' => 'jbonva@gmail.com',
            'massage' => 'Test Message',
        ];
        $this->post('/contact', $data);
    }

    /** @test * */
    public function it_can_translate_the_website()
    {
        $this->assertEquals('en', app()->getLocale());

        $this->get('/translate/fr');

        $this->assertEquals('fr', app()->getLocale());
    }
}
