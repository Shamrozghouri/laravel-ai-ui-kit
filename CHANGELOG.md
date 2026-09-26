# Changelog

All notable changes to `laravel-ui-ai-kit` are documented here.

## [Unreleased]

### Added
- GitHub Actions workflow (`.github/workflows/tests.yml`): PHPUnit across PHP 8.1–8.3 × Laravel 10/11/12, plus PHPStan and Pint checks.
- Extracted the chat composer (textarea + send button) into its own `resources/views/components/chatbot/input.blade.php` anonymous component, completing the Chatbot / ChatbotButton / ChatbotWindow / ChatMessage / ChatInput set — every piece of the widget is now independently `@include`-able or overridable without forking the whole thing. Documented all five in the README.
- Split `resources/css/landing.css` out of `ui-ai-kit.css`: the landing page's own stylesheet, loaded only by `layouts/landing.blade.php` and served via a new `landing.css` asset route/publish entry. `ui-ai-kit.css` now holds only the shared theme tokens and the chat widget, so a standalone `<x-ui-ai-kit::chatbot />` install no longer downloads landing page CSS it doesn't use. The chat widget's local variable fallbacks were also completed (added `--uiaikit-font`) so it now renders fully themed even without the `.uiaikit` layout wrapper.
- `resources/images/` placeholder directory for future logo/screenshot assets.
- Config-driven landing page at a configurable route.
- `<x-ui-ai-kit::chatbot />` Blade component with floating button, window, history, typing and error states.
- Chat endpoint with validation, throttling and swappable drivers (`echo`, `forward`, custom).
- `php artisan ui-ai-kit:install` to publish config and assets.
- Laravel-themed stylesheet driven by CSS custom properties, no build step.
