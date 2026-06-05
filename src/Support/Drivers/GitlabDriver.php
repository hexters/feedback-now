<?php

namespace Hexters\FeedbackNow\Support\Drivers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class GitlabDriver extends AbstractDriver
{
    public function report(string $title, string $description, array $meta, array $screenshots): string
    {
        $token = config('feedback-now.token');
        $base  = rtrim(config('feedback-now.gitlab_host', 'https://gitlab.com'), '/')
            . '/api/v4/projects/' . rawurlencode((string) config('feedback-now.repo'));

        $images = [];
        foreach ($screenshots as $shot) {
            $markdown = $this->uploadScreenshot($base, $token, $shot['file']);
            if ($markdown) {
                $images[] = $this->imageBlock($shot['notes'] ?? [], $markdown);
            }
        }

        $response = $this->client($token)->post("{$base}/issues", [
            'title'       => $title,
            'description' => $this->buildBody($description, $meta, $images),
            'labels'      => implode(',', config('feedback-now.labels', [])),
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('GitLab API error: HTTP ' . $response->status());
        }

        return (string) $response->json('web_url');
    }

    protected function uploadScreenshot(string $base, string $token, UploadedFile $screenshot): ?string
    {
        $response = $this->client($token)
            ->attach('file', (string) file_get_contents($screenshot->getRealPath()), $screenshot->getClientOriginalName() ?: 'screenshot.png')
            ->post("{$base}/uploads");

        // GitLab returns ready-to-embed markdown for the upload.
        return $response->successful() ? $response->json('markdown') : null;
    }

    protected function client(string $token)
    {
        return Http::withHeaders(['PRIVATE-TOKEN' => $token]);
    }
}
