# Changelog

All notable changes to `laravel-ui-ai-kit` are documented here.

## [Unreleased]

### Added
- GitHub Actions workflow (`.github/workflows/tests.yml`): PHPUnit across PHP 8.1–8.3 × Laravel 10/11/12, plus PHPStan and Pint checks.
- Config-driven landing page at a configurable route.
- `<x-ui-ai-kit::chatbot />` Blade component with floating button, window, history, typing and error states.
- Chat endpoint with validation, throttling and swappable drivers (`echo`, `forward`, custom).
- `php artisan ui-ai-kit:install` to publish config and assets.
- Laravel-themed stylesheet driven by CSS custom properties, no build step.
