# Feedback Now

[![Latest Stable Version](https://poser.pugx.org/hexters/feedback-now/v/stable)](https://packagist.org/packages/hexters/feedback-now)
[![Total Downloads](https://poser.pugx.org/hexters/feedback-now/downloads)](https://packagist.org/packages/hexters/feedback-now)
[![Tests](https://github.com/hexters/feedback-now/actions/workflows/tests.yml/badge.svg)](https://github.com/hexters/feedback-now/actions/workflows/tests.yml)
[![License](https://poser.pugx.org/hexters/feedback-now/license)](https://packagist.org/packages/hexters/feedback-now)

A floating "Report issue" button for the Laravel apps you ship to clients. The client clicks it on any page, types what went wrong, marks up a screenshot, and it lands as an issue in your GitHub or GitLab repo.

The point is to close the loop between the people using your app and the AI that fixes it. The client reports the bug in plain words with an annotated screenshot. The issue carries the exact path and context. Then your coding agent (Claude Code, Cursor, whatever you run) reads it and ships the fix. No more "the thing is broken" over WhatsApp.

Install once and it shows on every page. No layout edits, no frontend build.

![The report form a client sees on any page](art/report.png)

## Documentation

Full guide, screenshots, and configuration:

### → https://hexters.github.io/feedback-now/

## Quick start

```bash
composer require hexters/feedback-now
php artisan vendor:publish --tag=feedback-now-config
```

Set three values in `.env`. The button turns on wherever a token is set, so leaving the token out of production keeps it off there.

```dotenv
FEEDBACK_NOW_PROVIDER=github       # or gitlab
FEEDBACK_NOW_TOKEN=ghp_xxx
FEEDBACK_NOW_REPO=owner/repo        # GitLab: the numeric project id
```

On GitHub the token must be a **classic** personal access token with the `repo` scope; give it an expiry that matches the job (6 months, or just the testing window). On GitLab, create a **personal access token** with the **`api`** scope (User Settings → Access Tokens). See the [documentation](https://hexters.github.io/feedback-now/) for everything else.

## License

MIT.
