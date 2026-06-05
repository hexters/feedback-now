<?php

namespace Hexters\FeedbackNow\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class EndpointTest extends TestCase
{
    public function test_it_rejects_without_a_token(): void
    {
        config()->set('feedback-now.token', null);

        $this->withoutMiddleware()
            ->postJson('/feedback-now', ['url' => 'https://x.test', 'description' => 'broken'])
            ->assertForbidden();
    }

    public function test_it_validates_the_description(): void
    {
        $this->withoutMiddleware()
            ->postJson('/feedback-now', ['url' => 'https://x.test'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('description');
    }

    public function test_it_creates_a_github_issue(): void
    {
        Http::fake([
            'api.github.com/repos/*/issues' => Http::response(['html_url' => 'https://github.com/acme/shop/issues/7'], 201),
        ]);

        $this->withoutMiddleware()
            ->postJson('/feedback-now', ['url' => 'https://shop.test/cart', 'description' => 'Checkout button is dead'])
            ->assertOk()
            ->assertJson(['ok' => true, 'url' => 'https://github.com/acme/shop/issues/7']);

        Http::assertSent(fn ($r) => str_contains($r->url(), '/repos/acme/shop/issues')
            && $r['title'] === '[Feedback] Checkout button is dead'
            && str_contains($r['body'], 'https://shop.test/cart'));
    }

    public function test_it_commits_screenshots_with_color_notes(): void
    {
        Http::fake([
            'api.github.com/repos/*/contents/*' => Http::response(['content' => ['download_url' => 'https://raw.example/s.png']], 201),
            'api.github.com/repos/*/issues'     => Http::response(['html_url' => 'https://github.com/acme/shop/issues/8'], 201),
        ]);

        $this->withoutMiddleware()
            ->post('/feedback-now', [
                'url'         => '/cart',
                'description' => 'See screenshots',
                'screenshots' => [
                    UploadedFile::fake()->image('a.png', 800, 600),
                    UploadedFile::fake()->image('b.png', 800, 600),
                ],
                'notes' => [
                    json_encode([['color' => 'danger', 'text' => 'change to Home']]),
                    json_encode([['color' => 'info', 'text' => 'align this']]),
                ],
            ])
            ->assertOk()
            ->assertJson(['ok' => true]);

        // Two screenshots committed; both color notes embedded in the issue body.
        Http::assertSentCount(3); // 2 contents PUT + 1 issue POST
        Http::assertSent(fn ($r) => str_contains($r->url(), '/issues')
            && str_contains($r['body'], '1. **Danger** — change to Home')
            && str_contains($r['body'], '1. **Info** — align this')
            && str_contains($r['body'], 'raw.example/s.png'));
    }

    public function test_it_creates_a_gitlab_issue(): void
    {
        config()->set('feedback-now.provider', 'gitlab');

        Http::fake([
            'gitlab.com/api/v4/projects/*/issues' => Http::response(['web_url' => 'https://gitlab.com/acme/shop/-/issues/3'], 201),
        ]);

        $this->withoutMiddleware()
            ->postJson('/feedback-now', ['url' => 'https://shop.test', 'description' => 'Typo on homepage'])
            ->assertOk()
            ->assertJson(['ok' => true, 'url' => 'https://gitlab.com/acme/shop/-/issues/3']);
    }
}
