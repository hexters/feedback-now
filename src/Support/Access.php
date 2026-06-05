<?php

namespace Hexters\FeedbackNow\Support;

class Access
{
    /**
     * Whether the button and endpoint are active for the current request.
     *
     * It switches on wherever a token is configured. Because .env differs per
     * environment, leaving the token out of production's .env keeps the button
     * off there. No token also means there is nowhere to send the issue.
     */
    public static function enabled(): bool
    {
        return filled(config('feedback-now.token'));
    }
}
