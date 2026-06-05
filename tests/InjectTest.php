<?php

namespace Hexters\FeedbackNow\Tests;

class InjectTest extends TestCase
{
    public function test_it_injects_the_button_on_html_pages_when_enabled(): void
    {
        $this->get('/_fbn_page')
            ->assertOk()
            ->assertSee('id="fbn-root"', false)
            ->assertSee('fbn-fab', false);
    }

    public function test_it_does_not_inject_without_a_token(): void
    {
        config()->set('feedback-now.token', null);

        $this->get('/_fbn_page')
            ->assertOk()
            ->assertDontSee('fbn-root', false);
    }
}
