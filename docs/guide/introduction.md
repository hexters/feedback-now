---
description: What Feedback Now is — a floating in-app report button for Laravel that turns client bug reports with annotated screenshots into GitHub or GitLab issues.
---

# Introduction

Feedback Now is a floating "Report issue" button for the Laravel apps you ship to clients. A client clicks it on any page, types what went wrong, marks up a screenshot, and it lands as an issue in your GitHub or GitLab repository.

The point is to close the loop between the people using your app and the AI that fixes it. The client reports the bug in plain words with an annotated screenshot. The issue carries the exact path and context. Then your coding agent — Claude Code, Cursor, whatever you run — reads it and ships the fix.

No more "the thing is broken" over WhatsApp.

## How the flow works

1. The package injects a small button into every HTML page (a global middleware appends it before `</body>`).
2. Clicking it opens a popup with the current path, a description box, and a screenshot area where the client can draw, drop, or paste images and write a short note on each.
3. Submitting posts to a package route, and a driver creates the issue in your configured provider.

The Git token stays on the server. The browser only ever talks to your own app.

## What you get

- A button on **every page**, with no layout edits and no frontend build.
- **Screenshot mark-up**: draw in four colors, with a note pinned to each mark.
- **GitHub and GitLab** support from one token and one repo.
- It stays **off in production** by default, and the submit endpoint is rate limited.
- Plain vanilla JS and scoped CSS — it never touches your app's styles.

::: tip Requirements
PHP 8.2+ and Laravel 11, 12, or 13. MIT licensed.
:::

Next: [Installation](/guide/installation).
