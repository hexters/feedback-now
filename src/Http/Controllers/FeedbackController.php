<?php

namespace Hexters\FeedbackNow\Http\Controllers;

use Hexters\FeedbackNow\Support\Access;
use Hexters\FeedbackNow\Support\IssueReporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        abort_unless(Access::enabled(), 403);

        $data = $request->validate([
            'url'           => ['required', 'string', 'max:2000'],
            'description'   => ['required', 'string', 'max:5000'],
            'screenshots'   => ['nullable', 'array', 'max:10'],
            'screenshots.*' => ['image', 'max:' . config('feedback-now.max_screenshot_kb', 5120)],
            'notes'         => ['nullable', 'array'],
            'notes.*'       => ['nullable', 'string', 'max:4000'],
        ]);

        $title = trim(config('feedback-now.title_prefix', '[Feedback]') . ' '
            . Str::limit(preg_replace('/\s+/', ' ', strip_tags($data['description'])), 60));

        $meta = [
            'url'        => $data['url'],
            'reporter'   => optional($request->user())->name ?? optional($request->user())->email,
            'user_agent' => $request->userAgent(),
        ];

        $rawNotes = $request->input('notes', []);
        $screenshots = [];
        foreach (($request->file('screenshots') ?? []) as $i => $file) {
            $decoded = json_decode($rawNotes[$i] ?? '[]', true);
            $screenshots[] = ['file' => $file, 'notes' => is_array($decoded) ? $decoded : []];
        }

        try {
            $url = IssueReporter::driver()->report($title, $data['description'], $meta, $screenshots);

            return response()->json(['ok' => true, 'url' => $url]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
