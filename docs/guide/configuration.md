---
description: Every Feedback Now config option — provider, token, repo, button look, labels, screenshot path, and upload limits.
---

# Configuration

The essentials live in `.env`; everything else has a sensible default in `config/feedback-now.php`. Publish it with:

```bash
php artisan vendor:publish --tag=feedback-now-config
```

## The .env values

| Key | What it does |
|-----|--------------|
| `FEEDBACK_NOW_PROVIDER` | `github` or `gitlab`. |
| `FEEDBACK_NOW_TOKEN` | The access token. The button is active only when this is set. |
| `FEEDBACK_NOW_REPO` | GitHub `owner/repo`, or the GitLab numeric project id. |
| `FEEDBACK_NOW_GITLAB_HOST` | Only for self-hosted GitLab. Defaults to `https://gitlab.com`. |

## The config file

```php
return [
    'provider' => env('FEEDBACK_NOW_PROVIDER', 'github'),
    'token'    => env('FEEDBACK_NOW_TOKEN'),
    'repo'     => env('FEEDBACK_NOW_REPO'),
    'gitlab_host' => env('FEEDBACK_NOW_GITLAB_HOST', 'https://gitlab.com'),

    // Labels applied to every created issue.
    'labels' => ['feedback'],

    // GitHub commits screenshots to the repo (its API can't attach images).
    'screenshot_path'   => 'feedback-screenshots',
    'screenshot_branch' => null, // null = the default branch

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
```

## Common tweaks

- **Button look** — change `button.label`, `button.position`, and `button.color`.
- **Issue labels** — edit `labels`, e.g. `['feedback', 'from-client']`.
- **Title prefix** — every issue title starts with `title_prefix` (default `[Feedback]`).
- **Screenshot location (GitHub)** — set `screenshot_path` and `screenshot_branch` to keep images off your default branch.
- **Upload size** — `max_screenshot_kb` caps each image (default 5 MB).
