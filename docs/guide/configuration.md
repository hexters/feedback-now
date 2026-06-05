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

    // Primary accent — button, primary actions, focus rings, links.
    'accent' => env('FEEDBACK_NOW_ACCENT', '#2f6fed'),

    'button' => [
        'label'    => 'Report issue',
        'position' => 'bottom-right', // see the eight positions below
        'color'    => null,           // overrides just the button; defaults to accent
    ],

    // Paths where the button should NOT appear (wildcards via Request::is).
    'except' => [
        // 'admin/*',
        // 'login',
    ],

    'title_prefix'      => '[Feedback]',
    'max_screenshot_kb' => 5120,

    'route_prefix' => 'feedback-now',
    'middleware'   => ['web'],
];
```

## Common tweaks

- **Button position** — `button.position` takes one of eight spots:

  | | | |
  |--|--|--|
  | `top-left` | `top-center` | `top-right` |
  | `middle-left` | | `middle-right` |
  | `bottom-left` | `bottom-center` | `bottom-right` |

- **Hide it on some pages** — list paths in `except`. Wildcards are matched with `Request::is()`:

  ```php
  'except' => ['admin', 'admin/*', 'checkout/*'],
  ```

- **Accent color** — set `accent` (or `FEEDBACK_NOW_ACCENT`) to recolor the button, primary actions, and focus rings in one place. Use `button.color` only if you want the floating button a different color from the accent.
- **Button label** — change `button.label`.
- **Issue labels** — edit `labels`, e.g. `['feedback', 'from-client']`.
- **Title prefix** — every issue title starts with `title_prefix` (default `[Feedback]`).
- **Screenshot location (GitHub)** — set `screenshot_path` and `screenshot_branch` to keep images off your default branch.
- **Upload size** — `max_screenshot_kb` caps each image (default 5 MB).
