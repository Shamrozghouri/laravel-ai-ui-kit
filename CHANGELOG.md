# Changelog

All notable changes to `laravel-ui-ai-kit` are documented here, following [Keep a Changelog](https://keepachangelog.com/).

## [1.1.1] - 2026-09-29

### Fixed

- Corrected Composer and landing-page links to the actual `Shamrozghouri/laravel-ai-ui-kit` GitHub repository.
- Expanded the README with complete documentation for the full chatbot interface, response skeleton, creator content, Laravel Agent Evals card, routes, and customization flow.

## [1.1.0] - 2026-09-29

### Added

- Added an installer choice between a complete landing page and a full ChatGPT-style chatbot interface at the application root.
- Added the full chatbot page with starter prompts, local browser history, responsive navigation, theme switching, and an accessible response skeleton while queries run.
- Added richer landing sections, including the assistant preview, FAQs, configurable section ordering, lead-form support, creator cards, and a Laravel Agent Evals feature card with a copyable install command.
- Added automated coverage for the installer experiences, chatbot page, landing sections, published assets, accessibility labels, and response skeleton.

### Changed

- Expanded the landing-page design, responsive behavior, navigation, pricing, calls to action, branding, and conversion events.
- Improved floating-widget labels, layout configuration, avatar handling, input focus styling, and button presentation.
- Made an unpaired final feature card span the full grid width and made package content easier to customize from `config/ui-ai-kit.php`.
- Documented safe package updates, published-view behavior, and asset overwrite precautions.

### Fixed

- Isolated package tests from stale Testbench environment and configuration files.
- Kept chat provider credentials server-side and preserved escaped output throughout the new interfaces.

## [1.0.2] - 2026-09-28

### Changed

- Replaced the closed Laravel major-version constraints with a Laravel 10+ range so future framework releases are not blocked by Composer solely due to their version number.
- Added Laravel 13 and PHP 8.5 to the tested compatibility matrix.
- Allowed Guzzle 8 so the package does not force newer Laravel applications to downgrade their HTTP client.
- Added an unpinned latest-stable Laravel CI job and a weekly compatibility run to detect new framework releases automatically.

## [1.0.1] - 2026-09-28

### Fixed

- Configured the Testbench application key so encrypted cookies and HTTP feature tests work consistently across the supported Laravel matrix.
- Registered `<x-ui-ai-kit::chatbot />` as the class-based component entry point while retaining the anonymous internal component namespace.
- Corrected mixed Blade `@php` directives in the chatbot window that could leave avatar state undefined.
- Declared Guzzle as a runtime dependency for the forwarding driver.

### Changed

- Declared the directly used Illuminate Console and Routing components and restored Composer's stable default dependency policy.
- Expanded the README with accurate component, environment, route-security, asset-upgrade, and custom-driver guidance.
- Enabled the GitHub Actions test workflow for version-tag pushes as well as `main` and pull requests.

## [1.0.0] - 2026-09-27

Initial release.

### Added

- **Landing page** — config-driven marketing page (`/ui-ai-kit` by default): hero, features, how-it-works, stats, pricing, testimonials, CTA, footer. Every string lives in `config/ui-ai-kit.php`; removing a block removes that section, no Blade editing required.
- **Chatbot UI** — a floating `<x-ui-ai-kit::chatbot />` widget: open/close animation, message history, typing indicator, error state with retry, empty state, mobile responsiveness, and full keyboard support (Enter to send, Shift+Enter for a newline, Escape to close). A full-page "console" alternative is also included at `/ui-ai-kit/console`.
- **Configuration** — branding, theme (accent color/light-dark mode/fonts as CSS custom properties, no build step), landing page toggle/route/content, chatbot behavior and avatar, console layout/branding/nav, and API/driver settings, all `env()`-backed.
- **Blade components** — the widget is split into five independently overridable pieces: `Chatbot`, `ChatbotWindow`, `ChatbotButton`, `ChatMessage`, `ChatInput`.
- **Chat API** — a package-owned `POST` endpoint backed by a swappable `ChatDriver` contract. Ships with `echo` (works with zero setup) and `forward` (proxies to any HTTP endpoint you control, keeping API keys server-side) drivers, and supports custom drivers — including one generated for you by the install wizard.
- **`php artisan ui-ai-kit:install`** — publishes config and assets, and (unless run with `--no-wizard`) walks through an interactive setup: assistant name, tagline, accent color, light/dark mode, enabling the console/widget, and choosing a chat driver (including generating a custom driver stub).
- **Security** — CSRF-protected chat endpoint, request validation, rate limiting (20 requests/minute by default), XSS-safe `textContent` rendering client-side and Blade escaping server-side, and generic (non-leaking) API error responses.
- **Laravel support** — PHP 8.1–8.4, Laravel 10, 11, and 12, verified in CI across the full matrix alongside PHPUnit, PHPStan, and Pint.
- Full documentation in the README, covering installation, configuration, customization, API integration, publishing, and examples.

