<?php

namespace Hexters\FeedbackNow\Http\Middleware;

use Closure;
use Hexters\FeedbackNow\Support\Access;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class InjectFeedbackButton
{
    public function handle(Request $request, Closure $next): BaseResponse
    {
        $response = $next($request);

        if (! Access::enabled() || ! $this->injectable($request, $response)) {
            return $response;
        }

        $content = $response->getContent();

        if (! is_string($content) || stripos($content, '</body>') === false) {
            return $response;
        }

        $widget = view('feedback-now::widget', [
            'endpoint' => url(config('feedback-now.route_prefix', 'feedback-now')),
            'csrf'     => csrf_token(),
            'accent'   => config('feedback-now.accent', '#2f6fed'),
            'button'   => config('feedback-now.button'),
            'maxKb'    => (int) config('feedback-now.max_screenshot_kb', 5120),
        ])->render();

        $response->setContent(str_ireplace('</body>', $widget . "\n</body>", $content));

        return $response;
    }

    /** Only inject into real, full HTML page responses. */
    protected function injectable(Request $request, BaseResponse $response): bool
    {
        if ($request->ajax() || $request->wantsJson() || $request->pjax()) {
            return false;
        }

        // Pages the button is told to stay off (supports wildcards).
        $except = array_filter((array) config('feedback-now.except', []));
        if ($except && $request->is(...$except)) {
            return false;
        }

        // Skip redirects, JSON, streamed and binary responses.
        if (! $response instanceof Response) {
            return false;
        }

        return str_contains(strtolower((string) $response->headers->get('Content-Type', 'text/html')), 'text/html');
    }
}
