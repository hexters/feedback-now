<?php

namespace Hexters\FeedbackNow\Support\Drivers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GithubDriver extends AbstractDriver
{
    public function report(string $title, string $description, array $meta, array $screenshots): string
    {
        $token = config('feedback-now.token');
        $repo  = config('feedback-now.repo'); // "owner/repo"

        $images = [];
        foreach ($screenshots as $shot) {
            $url = $this->uploadScreenshot($token, $repo, $shot['file']);
            if ($url) {
                $images[] = $this->imageBlock($shot['notes'] ?? [], "![screenshot]({$url})");
            }
        }

        $response = $this->client($token)->post("https://api.github.com/repos/{$repo}/issues", [
            'title'  => $title,
            'body'   => $this->buildBody($description, $meta, $images),
            'labels' => config('feedback-now.labels', []),
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('GitHub API error: ' . ($response->json('message') ?? 'HTTP ' . $response->status()));
        }

        return (string) $response->json('html_url');
    }

    /**
     * GitHub's API cannot attach an image to an issue, so commit it to the repo
     * and return the raw URL.
     */
    protected function uploadScreenshot(string $token, string $repo, UploadedFile $screenshot): ?string
    {
        $path = trim(config('feedback-now.screenshot_path', 'feedback-screenshots'), '/')
            . '/' . date('Y/m') . '/' . Str::uuid() . '.' . ($screenshot->extension() ?: 'png');

        $response = $this->client($token)->put(
            "https://api.github.com/repos/{$repo}/contents/{$path}",
            array_filter([
                'message' => 'Add feedback screenshot',
                'content' => base64_encode((string) file_get_contents($screenshot->getRealPath())),
                'branch'  => config('feedback-now.screenshot_branch') ?: null,
            ], fn ($v) => $v !== null),
        );

        return $response->successful() ? $response->json('content.download_url') : null;
    }

    protected function client(string $token)
    {
        return Http::withToken($token)->withHeaders([
            'Accept'               => 'application/vnd.github+json',
            'X-GitHub-Api-Version' => '2022-11-28',
            'User-Agent'           => 'feedback-now',
        ]);
    }
}
