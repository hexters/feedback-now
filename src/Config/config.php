<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The essentials (.env)
    |--------------------------------------------------------------------------
    |
    | Set these three. The button switches on automatically wherever a token
    | is present, so to keep it out of production just leave the token out of
    | production's .env (.env differs per environment).
    |
    |   FEEDBACK_NOW_PROVIDER=github            # github | gitlab
    |   FEEDBACK_NOW_TOKEN=ghp_xxxxx
    |   FEEDBACK_NOW_REPO=owner/repo            # GitLab: the numeric project id
    |
    */

    'provider' => env('FEEDBACK_NOW_PROVIDER', 'github'),
    'token'    => env('FEEDBACK_NOW_TOKEN'),
    'repo'     => env('FEEDBACK_NOW_REPO'),

    // Only for self-hosted GitLab.
    'gitlab_host' => env('FEEDBACK_NOW_GITLAB_HOST', 'https://gitlab.com'),

    /*
    |--------------------------------------------------------------------------
    | Everything below has sensible defaults — tweak here, not in .env
    |--------------------------------------------------------------------------
    */

    // Labels applied to every created issue.
    'labels' => ['feedback'],

    // GitHub commits screenshots to the repo (its API can't attach images).
    'screenshot_path'   => 'feedback-screenshots',
    'screenshot_branch' => null, // null = the default branch

    // Button look.
    'button' => [
        'label'    => 'Report issue',
        'position' => 'bottom-right', // bottom-right | bottom-left
        'color'    => '#2f6fed',
    ],

    'title_prefix'      => '[Feedback]',
    'max_screenshot_kb' => 5120,

    'route_prefix' => 'feedback-now',
    'middleware'   => ['web'],

];
