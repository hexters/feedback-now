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

    public function test_it_does_not_inject_on_excepted_paths(): void
    {
        config()->set('feedback-now.except', ['_fbn_page']);

        $this->get('/_fbn_page')->assertOk()->assertDontSee('fbn-root', false);
    }

    public function test_except_supports_wildcards(): void
    {
        config()->set('feedback-now.except', ['_fbn_*']);

        $this->get('/_fbn_page')->assertOk()->assertDontSee('fbn-root', false);
    }

    public function test_button_position_is_configurable(): void
    {
        config()->set('feedback-now.button.position', 'top-left');

        $this->get('/_fbn_page')->assertSee('top:22px;left:22px', false);
    }

    public function test_accent_color_is_configurable(): void
    {
        config()->set('feedback-now.accent', '#ff0055');

        $this->get('/_fbn_page')->assertSee('--fbn-accent: #ff0055', false);
    }
}
