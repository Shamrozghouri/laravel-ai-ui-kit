# Laravel UI AI Kit

## Description

A drop-in landing page, floating AI widget, and full chatbot interface for Laravel applications. Install it with Composer, choose the experience that should own `/`, and connect whichever AI provider you already use — without a frontend build step.

## Features

- Landing page whose primary marketing copy lives in config — no Blade edits needed to change headlines, sections, or pricing
- Full ChatGPT-style chatbot page with starter prompts, browser-local history, responsive navigation, and a response skeleton
- `<x-ui-ai-kit::chatbot />` floating chat widget, plus an optional full-page "console" UI at its own route
- Split into five independently overridable Blade components (Chatbot, ChatbotWindow, ChatbotButton, ChatMessage, ChatInput)
- Swappable chat drivers (`echo`, `forward`, or your own `ChatDriver`), so API keys stay on the server, never in frontend JS
- Theming via CSS custom properties — accent color, light/dark mode, fonts, all config-driven, no build step to re-skin
- Plain CSS and vanilla JS — no Node, no build step, no framework lock-in
- Interactive `ui-ai-kit:install` wizard, including generating a custom driver class stub for you
- CSRF, request validation, rate limiting, and XSS-safe rendering handled out of the box
- Fully tested (PHPUnit) and statically analysed (PHPStan) across the whole supported version matrix in CI

## Requirements

- PHP 8.1 or newer
- Laravel 10 or newer

The package uses forward-compatible Composer constraints so a new Laravel major is not blocked merely because its version number is new. Laravel 10 through 13 are currently verified in CI; future majors remain subject to their own upstream breaking changes. See [Laravel Compatibility](#laravel-compatibility) for the combinations tested on every push.

## Installation

```bash
composer require shamrozghouri/laravel-ui-ai-kit
php artisan ui-ai-kit:install
```

The service provider is discovered automatically. The install command publishes `config/ui-ai-kit.php` and copies assets to `public/vendor/ui-ai-kit`. Its interactive wizard asks which experience should own `/`:

- **Full landing page** — the marketing page becomes the app home page.
- **Full chatbot interface** — a ChatGPT-style Laravel assistant becomes the app home page.

The selected experience is enabled at `/` and the other home-page experience is disabled. Composer itself does not execute interactive package prompts, so run `php artisan ui-ai-kit:install` after `composer require`. For automation, use `php artisan ui-ai-kit:install --no-wizard --experience=chat` or `--experience=landing`. The existing dashboard console remains a separate optional route; it is not one of the two home-page choices.

The full chatbot page is also available at `/ui-ai-kit/assistant` when enabled. It has local browser conversation history and uses the same configured chat API/driver as the widget. The default echo driver confirms the UI/API wiring; connect a real model with the existing `forward` or custom driver settings. Conversations are not stored on your server unless your driver/backend does so.

If your application caches configuration, clear that cache after the wizard changes `.env`:

```bash
php artisan config:clear
```

## Updating

Update the package and republish its versioned frontend assets:

```bash
composer update shamrozghouri/laravel-ui-ai-kit
php artisan vendor:publish --tag=ui-ai-kit-assets --force
php artisan config:clear
```

The asset command replaces files under `public/vendor/ui-ai-kit`. Keep custom CSS or JavaScript in your application, or back it up before using `--force`. The update does not overwrite `config/ui-ai-kit.php` or published Blade views, so your application-owned customizations remain intact. Compare your config with `vendor/shamrozghouri/laravel-ui-ai-kit/config/ui-ai-kit.php` when release notes mention new options. Published views also remain app-owned and do not receive package template changes automatically; avoid publishing them unless config customization is not enough.

## Quick Start

After the installer, the selected landing or chatbot experience opens at `/`. Without selecting a home experience, the default landing route is `/ui-ai-kit` and the full chatbot route is `/ui-ai-kit/assistant`. Add the floating widget to any Blade layout with:

```blade
<x-ui-ai-kit::chatbot />
```

Put it just before `</body>`. Make sure your layout has a CSRF meta tag:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

That's it — the widget answers locally out of the box (the `echo` driver), so there's something working immediately. Point it at a real AI provider whenever you're ready (see [API Integration](#api-integration)).

## Landing Page

```php
'landing' => [
    'enabled' => true,
    'route' => 'ui-ai-kit',       // or set UI_AI_KIT_LANDING_ROUTE
    'middleware' => ['web'],
],
```

Set `enabled` to `false` if you only want the chatbot.

Set `branding.logo` to your own logo. The `branding.logo_fallback` option defaults to `laravel` for the package demo; set it to `monogram` when using the page for another brand without a logo.

The `content` config key holds the landing page's marketing content: nav links, hero, assistant preview, features, steps, stats, pricing tiers, testimonials, FAQs, closing CTA and footer. Edit it and the page changes without modifying Blade. Remove a block (set it to `null` or an empty array) and that section disappears entirely. Use `content.sections` to choose and reorder sections; valid keys are `hero`, `logos`, `assistant-preview`, `features`, `how-it-works`, `stats`, `pricing`, `testimonials`, `faqs` and `cta`.

The CTA can include an optional lead form. Point `action` at a POST route in your Laravel app; the form includes Laravel's CSRF token, but your app remains responsible for validating and storing submissions. Redirect back with `->with('status', 'Thanks, we will be in touch.')` to show a success message.

```php
'content' => [
    'sections' => ['hero', 'features', 'pricing', 'faqs', 'cta'],
    'cta' => [
        'form' => [
            'action' => '/contact',
            'method' => 'POST',
            'submit_label' => 'Request a quote',
            'fields' => [
                ['name' => 'name', 'label' => 'Your name', 'type' => 'text', 'required' => true],
                ['name' => 'email', 'label' => 'Work email', 'type' => 'email', 'required' => true],
                ['name' => 'message', 'label' => 'What do you need?', 'type' => 'textarea'],
            ],
            'privacy_text' => 'Your information is handled under our',
            'privacy_label' => 'privacy policy',
            'privacy_href' => '/privacy',
        ],
    ],
],
```

The landing hero loads a pinned Three.js build from cdnjs only when the hero is near the viewport. It needs an internet connection; a CSS mascot remains when WebGL or the CDN is unavailable. Visitors who prefer reduced motion see a still scene.

Primary links emit a `uiaikit:conversion` document event with the placement, label and destination path. Lead forms emit `uiaikit:lead-submit` without including submitted field values. Listen to either event to connect your analytics provider; no tracking vendor or cookies are added by the package.

### Creator and Laravel Agent Evals cards

The default landing content includes creator cards for Shamroz Ghouri and a full-width Laravel Agent Evals feature card. The Agent Evals card briefly explains behavioral testing, baselines, regression detection, tagged runs, and JSON output for CI. Its copyable install command is:

```bash
composer require shamrozghouri/laravel-agent-evals
```

These are ordinary config-driven items, not hard requirements. Edit or remove them under `content.features` and `content.testimonials` in `config/ui-ai-kit.php` when adapting the landing page for another product.

```php
'content' => [
    'hero' => [
        'heading' => 'Your headline',
        'subheading' => 'Your supporting sentence.',
        'primary_cta' => ['label' => 'Get started', 'href' => '/register'],
        'install_command' => 'composer require vendor/package',
    ],
    // ...
],
```

## Chatbot

### Full Chatbot Interface

Choose **Full chatbot interface** in the installer to mount the responsive ChatGPT-style page at `/`, or enable it manually:

```php
'chat_page' => [
    'enabled' => true,
    'route' => 'ui-ai-kit/assistant',
    'title' => 'Laravel AI Assistant',
    'heading' => 'How can Laravel help you?',
    'subheading' => 'Ask about Laravel, your code, or what you are building.',
    'history_limit' => 30,
    'suggestions' => [
        [
            'title' => 'About the creator',
            'prompt' => 'Who is Shamroz Ghouri, and what does he build?',
            'answer' => 'Shamroz Ghouri creates open-source Laravel and AI tools.',
        ],
    ],
],
```

Each starter card contains a visible `title`, the user `prompt`, and an optional local-demo `answer`. The page uses the same server-side chat driver and CSRF-protected endpoint as the floating widget. Conversation history is stored in that browser only; add persistence in your own driver/backend when accounts need shared history across devices.

While a response is running, an accessible shimmer skeleton appears above the eventual answer. The interface also includes light/dark themes, responsive navigation, new-chat and clear-history actions, code-block rendering, error handling, and customizable branding. Edit `chat_page.heading`, `chat_page.subheading`, and `chat_page.suggestions` for content; publish `ui-ai-kit-chatbot-views` only when markup changes are necessary.

### Floating Chatbot Widget

```php
'chatbot' => [
    'enabled' => true,
    'name' => 'AI Assistant',
    'subtitle' => 'Usually replies instantly',
    'welcome_message' => 'How can I help?',
    'empty_message' => 'Ask a question to get started.',
    'footnote' => 'Answers are generated and may be wrong.',
    'placeholder' => 'Type your message',
    'open_label' => 'Open :name',
    'close_label' => 'Close :name',
    'send_label' => 'Send message',
    'position' => 'bottom-right',   // or bottom-left
    'avatar' => null,                // image URL/path, text, or fall back to branding.logo
    'open_on_load' => false,
    'layout' => ['width' => '380px', 'height' => '560px', 'offset' => '24px'],
    'suggestions' => ['How do I get started?'],
    'max_length' => 2000,
],
```

Any of these can be overridden per instance:

```blade
<x-ui-ai-kit::chatbot
    name="Support"
    subtitle="Here to help"
    welcome="Tell us what you need."
    placeholder="Ask support"
    position="bottom-left"
    avatar="/images/support-mark.svg"
    :suggestions="['Track an order', 'Talk to support']"
/>
```

### Publish and customize the UI

The package defaults work immediately; do not edit `vendor/`. The installer publishes the config and frontend assets. To copy only the chatbot UI views into your application, run:

```bash
php artisan vendor:publish --tag=ui-ai-kit-chatbot-views
```

The editable files are copied to:

- `resources/views/vendor/ui-ai-kit/components/chatbot/` — floating widget shell, header, launcher, message, suggestions and composer.
- `resources/views/vendor/ui-ai-kit/console/` — full-page console, including sidebar, header, conversation area and info panel.
- `resources/views/vendor/ui-ai-kit/chat-page/` — full ChatGPT-style home-page interface.

Laravel resolves these app-owned views before the package defaults. Edit the published files in your application; normal Composer updates do not overwrite them. The broader `php artisan vendor:publish --tag=ui-ai-kit-views` command still publishes every package view, including the landing page.

To customize colors, typography and detailed spacing without changing markup, publish the assets with `php artisan vendor:publish --tag=ui-ai-kit-assets`; edit `public/vendor/ui-ai-kit/css/ui-ai-kit.css` for the floating widget, `chat.css` for the full chatbot page, and `console.css` for the dashboard console. Theme mode, accent color, font family, monospace family, widget width/height/offset, copy, suggestions, avatar and open state are configured in `config/ui-ai-kit.php`. Light/dark mode follows `theme.mode`; the landing page toggle also switches its embedded widget. Re-running asset publishing with `--force` replaces your published CSS/JS, so keep your custom edits or copy them into your own stylesheet first.

The package supplies the UI only. The widget and console post to the configured chat route/driver. Connect your provider and persistence in your application; the default chat driver is for trying the UI and does not provide durable conversation history. Console sidebar links and quick actions are configuration data, not a built-in account/history backend.

### Console (full-page chatbot UI)

Prefer a full-screen, dashboard-style layout over the floating widget? Visit `/ui-ai-kit/console` (configurable) for a page with sidebar navigation, a header, a message thread with code-block support and timestamps, and a right-hand info panel with quick actions — it posts to the same chat endpoint as the widget above.

Everything is driven by config **and** `.env`, so end users can re-brand it after `composer require` without touching a single Blade file:

```php
'console' => [
    'enabled' => env('UI_AI_KIT_CONSOLE_ENABLED', true),
    'route' => env('UI_AI_KIT_CONSOLE_ROUTE', 'ui-ai-kit/console'),

    // Hide whole regions — useful when embedding inside an app that already
    // has its own sidebar or header.
    'layout' => [
        'show_sidebar' => env('UI_AI_KIT_CONSOLE_SIDEBAR', true),
        'show_panel' => env('UI_AI_KIT_CONSOLE_PANEL', true),
        'show_header' => env('UI_AI_KIT_CONSOLE_HEADER', true),
    ],

    'brand' => [
        'name' => env('UI_AI_KIT_CONSOLE_NAME', 'LaravelBot'),
        'logo' => env('UI_AI_KIT_CONSOLE_LOGO', null), // image URL, replaces the drawn mark
        // ...
    ],

    // Fully dynamic — add, remove or reorder sidebar links and quick actions.
    'nav' => [
        ['label' => 'Chat', 'icon' => 'chat', 'href' => '#', 'active' => true],
        // ...
    ],
    'quick_actions' => [
        ['label' => 'Laravel Documentation', 'icon' => 'book', 'prompt' => 'Where can I find the Laravel documentation?'],
        // ...
    ],
],
```

The main branding fields (brand name, tagline, welcome message, about copy, promo card, footer and user name/status) read from an `env()` value first, so most re-branding is a `.env` change and a config cache clear. `nav` and `quick_actions` stay as plain arrays since lists don't map cleanly to `.env`. A few fixed interface labels, such as “Quick Actions,” require a published view override.

## Configuration

Everything lives in `config/ui-ai-kit.php`.

### Branding and theme

```php
'branding' => [
    'name' => 'Acme',
    'monogram' => 'A',
    'logo' => null,          // URL or asset path
],

'theme' => [
    'mode' => 'dark',        // dark | light
    'accent' => '#F53003',   // any hex; written in as a CSS custom property
    'load_fonts' => true,
    'font_family' => "'Instrument Sans', ui-sans-serif, system-ui, sans-serif",
    'mono_family' => 'ui-monospace, SFMono-Regular, Menlo, monospace',
],
```

Changing `accent` re-skins the page and widget. Nothing is recompiled. The console shares the configured accent and font; publish its CSS when you need to adjust its individual surfaces.

### Interactive setup

`php artisan ui-ai-kit:install` runs a short wizard (skip it with `--no-wizard`) that asks whether the landing page or full chatbot should own `/`, then asks for the assistant name, tagline, accent colour, light/dark mode, floating widget preference, and chat driver. It writes those choices to `.env`. Run it again any time to change your mind:

```bash
php artisan ui-ai-kit:install
```

### Environment variables

Every value above that's wrapped in `env()` can be set here instead of editing the config array — this is what `php artisan ui-ai-kit:install`'s wizard writes to. All are optional; defaults match the LaravelBot look.

| Variable | Controls |
| --- | --- |
| `UI_AI_KIT_BRAND` | Shared landing page / widget brand name |
| `UI_AI_KIT_THEME` | `dark` or `light` — affects the widget, landing page and console |
| `UI_AI_KIT_ACCENT`, `UI_AI_KIT_ACCENT_HOVER` | Accent colour (hex) used everywhere |
| `UI_AI_KIT_LOAD_FONTS` | Whether to pull Instrument Sans from Google Fonts |
| `UI_AI_KIT_FONT_FAMILY` | CSS font stack used by the package UI |
| `UI_AI_KIT_LANDING_ENABLED`, `UI_AI_KIT_LANDING_ROUTE` | Landing page toggle / URL |
| `UI_AI_KIT_CHATBOT_ENABLED`, `UI_AI_KIT_CHATBOT_NAME` | Floating widget toggle / name |
| `UI_AI_KIT_CHATBOT_AVATAR` | Header icon override — image URL/path or an emoji |
| `UI_AI_KIT_CHAT_PAGE_ENABLED`, `UI_AI_KIT_CHAT_PAGE_ROUTE`, `UI_AI_KIT_CHAT_PAGE_TITLE` | Full chatbot page toggle / URL / browser title |
| `UI_AI_KIT_CONSOLE_ENABLED`, `UI_AI_KIT_CONSOLE_ROUTE` | Full-page console toggle / URL |
| `UI_AI_KIT_CONSOLE_TITLE` | Console browser-page title |
| `UI_AI_KIT_CONSOLE_SIDEBAR`, `UI_AI_KIT_CONSOLE_PANEL`, `UI_AI_KIT_CONSOLE_HEADER` | Show/hide console regions |
| `UI_AI_KIT_CONSOLE_NAME`, `UI_AI_KIT_CONSOLE_NAME_ACCENT`, `UI_AI_KIT_CONSOLE_TAGLINE` | Console brand text |
| `UI_AI_KIT_CONSOLE_LOGO` | Image URL/path shown instead of the drawn mark |
| `UI_AI_KIT_CONSOLE_HEADER_SUBTITLE`, `UI_AI_KIT_CONSOLE_FOOTER_TAGLINE` | Console header/sidebar copy |
| `UI_AI_KIT_CONSOLE_USER_NAME`, `UI_AI_KIT_CONSOLE_USER_INITIAL`, `UI_AI_KIT_CONSOLE_USER_STATUS` | Console header user chip |
| `UI_AI_KIT_CONSOLE_WELCOME`, `UI_AI_KIT_CONSOLE_PLACEHOLDER` | First message / input placeholder |
| `UI_AI_KIT_CONSOLE_ABOUT_HEADING`, `UI_AI_KIT_CONSOLE_ABOUT_SUBHEADING`, `UI_AI_KIT_CONSOLE_ABOUT_BODY` | Right-panel “about” card |
| `UI_AI_KIT_CONSOLE_PROMO_HEADING`, `UI_AI_KIT_CONSOLE_PROMO_BODY` | Right-panel promo card (empty heading hides it) |
| `UI_AI_KIT_CONSOLE_FOOTER_HEADING`, `UI_AI_KIT_CONSOLE_FOOTER_TAGLINE_SMALL` | Console sidebar footer card |
| `UI_AI_KIT_CHAT_ROUTE`, `UI_AI_KIT_CHAT_DRIVER`, `UI_AI_KIT_CHAT_ENDPOINT`, `UI_AI_KIT_CHAT_THROTTLE` | Chat API behaviour |

## Customization

- **Re-theme without touching CSS** — `theme.accent`, `theme.mode`, and `theme.load_fonts` are written in as CSS custom properties, so a color/mode change re-skins the landing page, console, and widget together.
- **Swap the widget's icon** — set `chatbot.avatar` to an image URL/path or an emoji (see [Chatbot](#chatbot)).
- **Override one piece of the widget** — every internal Blade file is independently addressable; see [Blade Components](#blade-components) rather than forking the whole thing.
- **Override a whole view** — publish views (`--tag=ui-ai-kit-views`) and edit anything under `resources/views/vendor/ui-ai-kit`. Only do this when config isn't enough — published views stop receiving package updates.
- **Answer chat messages your way** — implement your own `ChatDriver`, or let `ui-ai-kit:install` generate a stub for you (see [API Integration](#api-integration)).

## API Integration

The widget posts JSON to the package route:

```
POST /ui-ai-kit/chat
{ "message": "Hello", "conversation_id": null, "history": [] }

200 OK
{ "message": "Hi, how can I help?", "conversation_id": "abc" }
```

What happens next depends on `ui-ai-kit.api.driver`.

**`echo`** (default) replies locally so the widget works immediately.

**`forward`** proxies the message to an endpoint you control:

```php
'api' => [
    'driver' => 'forward',
    'endpoint' => env('UI_AI_KIT_CHAT_ENDPOINT'),
    'headers' => ['Authorization' => 'Bearer '.env('UI_AI_KIT_CHAT_TOKEN')],
],
```

The upstream endpoint receives the same `message`, `conversation_id`, and `history` fields. It should return JSON containing `message` (or `reply`) and may return `conversation_id`. Non-successful responses are converted into the package's generic chat error.

**Your own driver.** Implement the contract and bind it:

```php
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;

class OpenAiDriver implements ChatDriver
{
    public function send(string $message, ?string $conversationId = null, array $history = []): array
    {
        // call your provider here
        return ['message' => $reply, 'conversation_id' => $conversationId];
    }
}
```

```php
// AppServiceProvider::register()
$this->app->bind(ChatDriver::class, OpenAiDriver::class);
```

Or register it by name so it can be chosen from config:

```php
use Illuminate\Contracts\Container\Container;
use Shamrozghouri\LaravelUiAiKit\Services\ChatManager;

// AppServiceProvider::boot()
$this->app->make(ChatManager::class)->extend(
    'openai',
    fn (Container $app) => $app->make(OpenAiDriver::class),
);
```

Then set `UI_AI_KIT_CHAT_DRIVER=openai` and run `php artisan config:clear` if configuration is cached.

**Generating the stub for you.** Rather than writing the class by hand, choose "custom" for the driver question in `php artisan ui-ai-kit:install` — it writes `app/UiAiKit/{YourClassName}.php` from a stub with the `send()` method ready to fill in, sets `UI_AI_KIT_CHAT_DRIVER=custom` in `.env`, and prints the one-line `ChatManager::extend()` call to add to a service provider's `boot()`.

## Blade Components

The chat widget is split into small, independently overridable pieces rather than one large view. The main `chatbot` entry point is a class-based component so it can load configuration defaults and decide whether to render. Its four internal templates are anonymous components under the `ui-ai-kit::` namespace and can also be included as namespaced views.

| Component | Blade tag | Namespaced view | Required data |
| --- | --- | --- | --- |
| Chatbot | `<x-ui-ai-kit::chatbot />` | `ui-ai-kit::components.chatbot.chatbot` | Optional component attributes override config |
| ChatbotWindow | `<x-ui-ai-kit::chatbot.window />` | `ui-ai-kit::components.chatbot.window` | `name`, `welcome`, `placeholder`, `suggestions`, `avatar` |
| ChatbotButton | `<x-ui-ai-kit::chatbot.button />` | `ui-ai-kit::components.chatbot.button` | `name` |
| ChatMessage | `<x-ui-ai-kit::chatbot.message />` | `ui-ai-kit::components.chatbot.message` | `role`, `body` |
| ChatInput | `<x-ui-ai-kit::chatbot.input />` | `ui-ai-kit::components.chatbot.input` | `name`, `placeholder` |

The main component is the recommended public API. Internal components are intended for advanced composition; pass their required values as Blade attributes or include parameters.

## Publishing

```bash
php artisan vendor:publish --tag=ui-ai-kit-config
php artisan vendor:publish --tag=ui-ai-kit-assets
php artisan vendor:publish --tag=ui-ai-kit-views
```

Publish the views only when config is not enough — once published, package updates no longer reach them.

## Assets

CSS and JS are served directly from the package (via an internal asset route) the moment it's installed, so the UI is fully styled and interactive before you publish anything:

| File | Purpose |
| --- | --- |
| `css/ui-ai-kit.css` | Shared theme tokens + the chat widget. Loaded automatically wherever `<x-ui-ai-kit::chatbot />` is used |
| `css/landing.css` | Landing-page-only styles. Loaded only by the bundled landing layout |
| `css/console.css` | Full-page console styles |
| `js/chatbot.js` | Widget behaviour: open/close, sending, typing indicator, errors, keyboard support |
| `js/landing.js` | Landing page interactions |
| `js/console.js` | Console page behaviour |
| `images/` | Placeholder for a logo/screenshot asset, if you add one |

Publish them with `--tag=ui-ai-kit-assets` to copy everything above into `public/vendor/ui-ai-kit` and serve it from your own web server instead.

Published assets take precedence over the files inside the package. After upgrading the package, refresh them so old CSS or JavaScript is not left in place:

```bash
php artisan vendor:publish --tag=ui-ai-kit-assets --force
```

## Routes

The landing page, console, and chat routes are optional and config-driven. The fallback asset route is always registered at its fixed URI so unpublished package assets remain available:

| Route | Config | Default URI | Purpose |
| --- | --- | --- | --- |
| `ui-ai-kit.landing` | `landing.enabled`, `landing.route`, `landing.middleware` | `/ui-ai-kit` | The bundled landing page |
| `ui-ai-kit.console` | `console.enabled`, `console.route`, `console.middleware` | `/ui-ai-kit/console` | The full-page chatbot UI |
| `ui-ai-kit.chat` | `api.enabled`, `api.route`, `api.middleware`, `api.throttle` | `/ui-ai-kit/chat` | The `POST` endpoint the widget/console talk to |
| `ui-ai-kit.asset` | always registered | `/ui-ai-kit/assets/{file}` | Serves package CSS/JS before publishing |

## Security

- Credentials never reach the browser. The widget only ever talks to your Laravel route.
- The chat route runs the `web` middleware group, so CSRF protection applies; the widget sends the token from your meta tag.
- Requests are validated (`message` required, length-capped) and throttled — `ui-ai-kit.api.throttle` defaults to 20 requests a minute. Set it to `null` to disable.
- Messages are inserted with `textContent` in JavaScript and escaped by Blade on the server, so replies cannot inject markup.
- Driver failures are logged and returned as a generic message, not a stack trace.
- The landing page, console, and chat endpoint are public by default. Add middleware such as `auth` to their respective `middleware` arrays when they should only be available to signed-in users.

## Testing

```bash
composer test           # PHPUnit
composer analyse        # PHPStan
composer format:check   # Pint, dry run
composer format         # Pint, applies fixes
```

## Laravel Compatibility

Tested in CI (`.github/workflows/tests.yml`) across the full matrix:

| PHP | Laravel 10 | Laravel 11 | Laravel 12 | Laravel 13 |
| --- | :---: | :---: | :---: | :---: |
| 8.1 | ✅ | — | — | — |
| 8.2 | ✅ | ✅ | ✅ | — |
| 8.3 | ✅ | ✅ | ✅ | ✅ |
| 8.4 | — | — | ✅ | ✅ |
| 8.5 | — | — | — | ✅ |

Every push and pull request runs the full matrix, plus an unpinned latest-stable Laravel job, PHPStan, and Pint. The workflow also runs weekly so a newly released framework version is checked automatically.

## Examples

**Widget only, no landing page:**

```php
'landing' => ['enabled' => false],
```

```blade
<x-ui-ai-kit::chatbot />
```

**Branded, light-mode widget in the bottom-left:**

```blade
<x-ui-ai-kit::chatbot name="Acme Support" position="bottom-left" avatar="https://acme.test/logo.png" />
```

```env
UI_AI_KIT_THEME=light
UI_AI_KIT_ACCENT=#2563eb
```

**Forwarding to your own AI endpoint:**

```env
UI_AI_KIT_CHAT_DRIVER=forward
UI_AI_KIT_CHAT_ENDPOINT=https://api.acme.test/assistant
```

```php
'api' => [
    'headers' => ['Authorization' => 'Bearer '.env('ACME_ASSISTANT_TOKEN')],
],
```

## Contributing

1. Fork the repo and create a branch off `main`.
2. `composer install`
3. Make your change, keeping `composer test`, `composer analyse`, and `composer format:check` all green.
4. Open a pull request describing what changed and why.

CI runs the full test/analyse/format matrix on every pull request automatically.

## License

MIT. See [LICENSE](LICENSE).
