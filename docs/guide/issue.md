---
description: What a Feedback Now issue looks like — title, annotated screenshot, numbered color notes, and page metadata an AI agent can act on.
---

# The created issue

Here is what a report turns into on GitHub. GitLab looks the same, formatted for its own markdown.

![The created issue on GitHub with the annotated screenshot and notes](/issue.png)

## What's in it

- **Title** — `[Feedback]` plus the start of the client's description.
- **Body** — the full description.
- **Screenshots** — each annotated image, with the marks burned in.
- **Notes** — a numbered, color-coded list under each image (`1. Danger — …`), matched to the badges on the picture.
- **Metadata** — the page path, who reported it (if authenticated), the browser, and the time.
- **Label** — `feedback`, so you can filter.

## Why this shape

It is written to be picked up by a coding agent. The path tells it which route or view, the description says what is wrong, and the marked-up screenshot shows exactly where. Hand the issue to Claude Code, Cursor, or whatever you run, and it has enough to make the fix.

That is the whole loop: the client points at the problem, and your agent closes it.
