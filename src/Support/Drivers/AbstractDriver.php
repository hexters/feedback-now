<?php

namespace Hexters\FeedbackNow\Support\Drivers;

use Hexters\FeedbackNow\Support\Contracts\IssueDriver;

abstract class AbstractDriver implements IssueDriver
{
    /**
     * Compose the issue body: the description, any screenshots (each already
     * turned into provider-specific markdown, with its caption), and a small
     * metadata table.
     *
     * @param  array<string, mixed>  $meta
     * @param  array<int, string>  $images  rendered markdown blocks
     */
    protected function buildBody(string $description, array $meta, array $images): string
    {
        $lines = [trim($description), ''];

        if (! empty($images)) {
            $lines[] = '## Screenshots';
            $lines[] = '';
            foreach ($images as $image) {
                $lines[] = $image;
                $lines[] = '';
            }
        }

        $lines[] = '---';
        $lines[] = '';
        $lines[] = '| | |';
        $lines[] = '|-|-|';
        $lines[] = '| Page | ' . ($meta['url'] ?? '-') . ' |';

        if (! empty($meta['reporter'])) {
            $lines[] = '| Reported by | ' . $meta['reporter'] . ' |';
        }

        if (! empty($meta['user_agent'])) {
            $lines[] = '| User agent | ' . $meta['user_agent'] . ' |';
        }

        $lines[] = '| Submitted | ' . now()->toDateTimeString() . ' |';
        $lines[] = '';
        $lines[] = '<sub>Filed with feedback-now.</sub>';

        return implode("\n", $lines);
    }

    /**
     * One screenshot block: the image, then the client's color-coded notes.
     *
     * @param  array<int, array{color?: string, text?: string}>  $notes
     */
    protected function imageBlock(array $notes, string $imageMarkdown): string
    {
        $out = $imageMarkdown;

        $lines = [];
        $n = 1;
        foreach ($notes as $note) {
            $text = trim((string) ($note['text'] ?? ''));
            if ($text === '') {
                continue;
            }
            $color = ucfirst((string) ($note['color'] ?? 'note'));
            $lines[] = $n . '. **' . $color . '** — ' . $text;
            $n++;
        }

        if ($lines) {
            $out .= "\n\n" . implode("\n", $lines);
        }

        return $out;
    }
}
