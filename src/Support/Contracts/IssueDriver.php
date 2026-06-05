<?php

namespace Hexters\FeedbackNow\Support\Contracts;

interface IssueDriver
{
    /**
     * Create the issue and return its URL.
     *
     * @param  array<string, mixed>  $meta
     * @param  array<int, array{file: \Illuminate\Http\UploadedFile, caption: ?string}>  $screenshots
     */
    public function report(string $title, string $description, array $meta, array $screenshots): string;
}
