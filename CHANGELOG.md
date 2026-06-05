# Changelog

All notable changes to `hexters/feedback-now` are documented here. The format is
based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and the project
follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2026-06-05

### Added

- Eight button positions: `top` / `middle` / `bottom` × `left` / `center` / `right` (`button.position`).
- `except` config to hide the button on chosen paths, with wildcards matched by `Request::is()`.
- `accent` config (env `FEEDBACK_NOW_ACCENT`) for the primary color used across the button, the primary actions, focus rings, and links. `button.color` now optionally overrides just the floating button and defaults to the accent.

### Changed

- Mobile modals are now a native-style bottom sheet: a grab handle, a slide-up animation, drag-to-dismiss, and an edge-to-edge dock.
- Inputs render at 16px on mobile so iOS no longer zooms in on focus.

### Fixed

- Scroll conflict on mobile: the page behind the sheet is locked and overscroll is contained, so scrolling stays inside the modal.

## [1.0.0] - 2026-06-05

Initial release.

### Added

- Floating "Report issue" button injected on every page through a global middleware — no layout edits, no frontend build.
- Report form with an editable page path, a description, and multiple screenshots (click, drag, or paste).
- Screenshot mark-up: draw in four colors (info, success, warning, danger) and pin a note to each mark. Marks are numbered, burned into the image, and listed in the issue so every note points to its mark.
- GitHub and GitLab drivers. GitHub commits screenshots to the repo and embeds them; GitLab uploads them through its API.
- Activates only when a token is set, so it stays off in production by default.
- Configurable label, color, issue labels, title prefix, screenshot path and branch, and upload size limit.
- Rate-limited submit endpoint with image validation.
- Tested on PHP 8.2–8.4 and Laravel 11, 12, and 13.

[1.0.1]: https://github.com/hexters/feedback-now/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/hexters/feedback-now/releases/tag/1.0.0
