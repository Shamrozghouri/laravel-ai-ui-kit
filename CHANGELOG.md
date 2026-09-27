# Changelog

All notable changes to `laravel-ui-ai-kit` are documented here.

## [Unreleased]

### Added
- GitHub Actions workflow (`.github/workflows/tests.yml`): PHPUnit across PHP 8.1–8.3 × Laravel 10/11/12, plus PHPStan and Pint checks.
- CI matrix extended to include PHP 8.4 (paired with Laravel 12), matching the full supported version matrix.
- Explicit "service provider is registered" and "package views load" tests, rounding out the Service Provider test checklist alongside the existing config/route/asset tests.
- `php artisan ui-ai-kit:install` wizard: added a "custom" option to the driver question. Picking it generates a `ChatDriver` stub at `app/UiAiKit/{Class}.php` from `stubs/chat-driver.stub`, sets `UI_AI_KIT_CHAT_DRIVER=custom`, and prints the exact `ChatManager::extend()` snippet to register it.
- `resources/images/` is now included in the `ui-ai-kit-assets` publish group (published to `public/vendor/ui-ai-kit/images`), so a future logo/screenshot asset added there is publishable without a service provider change.
- `chatbot.avatar` config option (and matching `avatar` prop on `<x-ui-ai-kit::chatbot />`): overrides the widget header icon with an image URL/path, a data URI, or a short text/emoji string. Leave unset to keep the default icon. `UI_AI_KIT_CHATBOT_AVATAR` env var included.
- Chatbot empty state: when `chatbot.welcome_message` is blank, the message log now shows a centered placeholder ("Ask a question to get started.") instead of a bare empty scroll area. Clears automatically once the first message is sent.
- Extracted the chat composer (textarea + send button) into its own `resources/views/components/chatbot/input.blade.php` anonymous component, completing the Chatbot / ChatbotButton / ChatbotWindow / ChatMessage / ChatInput set — every piece of the widget is now independently `@include`-able or overridable without forking the whole thing. Documented all five in the README.
- Split `resources/css/landing.css` out of `ui-ai-kit.css`: the landing page's own stylesheet, loaded only by `layouts/landing.blade.php` and served via a new `landing.css` asset route/publish entry. `ui-ai-kit.css` now holds only the shared theme tokens and the chat widget, so a standalone `<x-ui-ai-kit::chatbot />` install no longer downloads landing page CSS it doesn't use. The chat widget's local variable fallbacks were also completed (added `--uiaikit-font`) so it now renders fully themed even without the `.uiaikit` layout wrapper.
- `resources/images/` placeholder directory for future logo/screenshot assets.
- Config-driven landing page at a configurable route.
- `<x-ui-ai-kit::chatbot />` Blade component with floating button, window, history, typing and error states.
- Chat endpoint with validation, throttling and swappable drivers (`echo`, `forward`, custom).
- `php artisan ui-ai-kit:install` to publish config and assets.
- Laravel-themed stylesheet driven by CSS custom properties, no build step.
