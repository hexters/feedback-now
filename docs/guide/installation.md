---
description: Install Feedback Now with Composer, publish the config, and set the three .env values that turn the button on.
---

# Installation

```bash
composer require hexters/feedback-now
php artisan vendor:publish --tag=feedback-now-config
```

That publishes `config/feedback-now.php`. Everything has a sensible default — you normally only touch the `.env`.

## Turn it on

Set three values. Because `.env` differs per environment, `FEEDBACK_NOW_TOKEN` is also how you keep the button out of production: set it in local and staging, leave it out in prod.

```dotenv
FEEDBACK_NOW_PROVIDER=github       # or gitlab
FEEDBACK_NOW_TOKEN=ghp_xxx
FEEDBACK_NOW_REPO=owner/repo        # GitLab: the numeric project id
```

That is the whole setup. The button now appears on every page in that environment.

::: warning No token, no button
The button (and the endpoint) switch on only when a token is present. Without one there is nowhere to send the issue, so nothing renders. That is the safe default for production.
:::

## Next

- [The report button](/guide/usage) — what the client sees and submits.
- [GitHub & GitLab](/guide/providers) — creating the token and pointing at a repo.
- [Configuration](/guide/configuration) — labels, button color, limits.
