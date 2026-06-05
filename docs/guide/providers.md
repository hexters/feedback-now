---
description: Point Feedback Now at GitHub or GitLab — creating the token, the right scopes, expiry, and the repo or project id.
---

# GitHub & GitLab

Feedback Now files issues through one of two providers. You set the provider, a token, and a repo in `.env`.

## GitHub

```dotenv
FEEDBACK_NOW_PROVIDER=github
FEEDBACK_NOW_TOKEN=ghp_xxx
FEEDBACK_NOW_REPO=owner/repo
```

The token has to be a **classic** personal access token, not a fine-grained one. Create it under **Settings → Developer settings → Personal access tokens → Tokens (classic)** and tick the `repo` scope.

Give it an expiry that matches the work — 6 months, or just the length of the testing phase. When it lapses the button quietly stops working until you replace it, which is what you want for a token that can write to your repo.

::: tip Screenshots on GitHub
GitHub's API cannot attach an image to an issue, so screenshots are committed to the repo (under `feedback-screenshots/` by default) and embedded. You can change the path or target a separate branch in the config.
:::

## GitLab

```dotenv
FEEDBACK_NOW_PROVIDER=gitlab
FEEDBACK_NOW_TOKEN=glpat-xxx
FEEDBACK_NOW_REPO=12345                 # the numeric project id
# FEEDBACK_NOW_GITLAB_HOST=https://gitlab.example.com   # self-hosted only
```

Use a personal access token with the `api` scope, and set an expiry the same way. `FEEDBACK_NOW_REPO` is the **numeric project id** (shown on the project's home page).

GitLab has a proper upload API, so screenshots are uploaded and linked without touching your code.

## Labels

Every issue gets the `feedback` label by default. Change the list in [configuration](/guide/configuration).
