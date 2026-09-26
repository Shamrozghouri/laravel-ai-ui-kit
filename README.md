# Laravel UI AI Kit

A drop-in landing page and AI chat widget for Laravel applications. Install it with Composer, publish the config, and you have a marketing page and a chatbot that talks to whichever AI provider you already use.

- Landing page whose copy lives entirely in config
- `<x-ui-ai-kit::chatbot />` Blade component you can drop into any layout
- Swappable chat drivers, so API keys stay on the server
- Plain CSS and vanilla JS — no Node, no build step
- Laravel 10, 11 and 12 on PHP 8.1+

## Installation

```bash
composer require shamrozghouri/laravel-ui-ai-kit
php artisan ui-ai-kit:install
```

The service provider is discovered automatically. The install command publishes `config/ui-ai-kit.php` and copies the assets to `public/vendor/ui-ai-kit`. Assets are also served straight from the package, so the UI works before you publish anything.

Visit `/ui-ai-kit` for the landing page, and add the widget to your own layout:

```blade
<x-ui-ai-kit::chatbot />
```

Put it just before `</body>`. Make sure your layout has a CSRF meta tag:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

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
],
```

Changing `accent` re-skins the whole page and the widget. Nothing is recompiled.

### Landing page

```php
'landing' => [
    'enabled' => true,
    'route' => 'ui-ai-kit',       // or set UI_AI_KIT_LANDING_ROUTE
    'middleware' => ['web'],
],
```

Set `enabled` to `false` if you only want the chatbot.

### Landing page content

The `content` key holds every string on the page: nav links, hero, features, steps, stats, pricing tiers, testimonials, closing CTA and footer. Edit it and the page changes. Remove a block — set it to `null` or an empty array — and that section disappears.

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

### Chatbot

```php
'chatbot' => [
    'enabled' => true,
    'name' => 'AI Assistant',
    'welcome_message' => 'How can I help?',
    'placeholder' => 'Type your message',
    'position' => 'bottom-right',   // or bottom-left
    'open_on_load' => false,
    'suggestions' => ['How do I get started?'],
    'max_length' => 2000,
],
```

Any of these can be overridden per instance:

```blade
<x-ui-ai-kit::chatbot name="Support" position="bottom-left" :open="true" />
```

### Console (full-page chatbot UI)

Prefer a full-screen, dashboard-style layout over the floating widget? Visit
`/ui-ai-kit/console` (configurable) for a page with sidebar navigation, a header,
a message thread with code-block support and timestamps, and a right-hand
info panel with quick actions — it posts to the same chat endpoint as the
widget above.

Everything is driven by config **and** `.env`, so end users can re-brand it
after `composer require` without touching a single Blade file:

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

Every text field on the page (brand name, tagline, welcome message, about
copy, promo card, footer, user name/status) reads from an `env()` value
first, so most re-branding is a `.env` change and a config cache clear —
no publishing or editing Blade required. `nav` and `quick_actions` stay as
plain arrays since lists don't map cleanly to `.env`, but they're still just
config — no view edits needed.

#### Interactive setup

`php artisan ui-ai-kit:install` now also runs a short wizard (skip it with
`--no-wizard`) that asks for the assistant's name, tagline, accent colour,
light/dark mode, whether to enable the console and the widget, and how chat
messages should be answered — then writes the answers straight to `.env`.
Run it again any time to change your mind:

```bash
php artisan ui-ai-kit:install
```

### Environment variables

Every value above that's wrapped in `env()` can be set here instead of
editing the config array — this is what `php artisan ui-ai-kit:install`'s
wizard writes to. All are optional; defaults match the LaravelBot look.

| Variable | Controls |
| --- | --- |
| `UI_AI_KIT_BRAND` | Shared landing page / widget brand name |
| `UI_AI_KIT_THEME` | `dark` or `light` — affects the widget, landing page and console |
| `UI_AI_KIT_ACCENT`, `UI_AI_KIT_ACCENT_HOVER` | Accent colour (hex) used everywhere |
| `UI_AI_KIT_LOAD_FONTS` | Whether to pull Instrument Sans from Google Fonts |
| `UI_AI_KIT_LANDING_ENABLED`, `UI_AI_KIT_LANDING_ROUTE` | Landing page toggle / URL |
| `UI_AI_KIT_CHATBOT_ENABLED`, `UI_AI_KIT_CHATBOT_NAME` | Floating widget toggle / name |
| `UI_AI_KIT_CONSOLE_ENABLED`, `UI_AI_KIT_CONSOLE_ROUTE` | Full-page console toggle / URL |
| `UI_AI_KIT_CONSOLE_SIDEBAR`, `UI_AI_KIT_CONSOLE_PANEL`, `UI_AI_KIT_CONSOLE_HEADER` | Show/hide console regions |
| `UI_AI_KIT_CONSOLE_NAME`, `UI_AI_KIT_CONSOLE_NAME_ACCENT`, `UI_AI_KIT_CONSOLE_TAGLINE` | Console brand text |
| `UI_AI_KIT_CONSOLE_LOGO` | Image URL/path shown instead of the drawn mark |
| `UI_AI_KIT_CONSOLE_HEADER_SUBTITLE`, `UI_AI_KIT_CONSOLE_FOOTER_TAGLINE` | Console header/sidebar copy |
| `UI_AI_KIT_CONSOLE_USER_NAME`, `UI_AI_KIT_CONSOLE_USER_INITIAL`, `UI_AI_KIT_CONSOLE_USER_STATUS` | Console header user chip |
| `UI_AI_KIT_CONSOLE_WELCOME`, `UI_AI_KIT_CONSOLE_PLACEHOLDER` | First message / input placeholder |
| `UI_AI_KIT_CONSOLE_ABOUT_HEADING`, `_SUBHEADING`, `_BODY` | Right-panel "about" card |
| `UI_AI_KIT_CONSOLE_PROMO_HEADING`, `UI_AI_KIT_CONSOLE_PROMO_BODY` | Right-panel promo card (empty heading hides it) |
| `UI_AI_KIT_CHAT_ROUTE`, `UI_AI_KIT_CHAT_DRIVER`, `UI_AI_KIT_CHAT_ENDPOINT`, `UI_AI_KIT_CHAT_THROTTLE` | Chat API behaviour |

## Connecting your AI provider

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
$this->app->make(ChatManager::class)->extend('openai', fn () => new OpenAiDriver);
```

## Security

- Credentials never reach the browser. The widget only ever talks to your Laravel route.
- The chat route runs the `web` middleware group, so CSRF protection applies; the widget sends the token from your meta tag.
- Requests are validated (`message` required, length-capped) and throttled — `ui-ai-kit.api.throttle` defaults to 20 requests a minute. Set it to `null` to disable.
- Messages are inserted with `textContent` in JavaScript and escaped by Blade on the server, so replies cannot inject markup.
- Driver failures are logged and returned as a generic message, not a stack trace.

## Publishing

```bash
php artisan vendor:publish --tag=ui-ai-kit-config
php artisan vendor:publish --tag=ui-ai-kit-assets
php artisan vendor:publish --tag=ui-ai-kit-views
```

Publish the views only when config is not enough — once published, package updates no longer reach them.

### Blade components

The chat widget is split into small, independently overridable pieces rather than one large view. Each is registered as an anonymous component under the `ui-ai-kit::` namespace, so you can `@include` or `<x-ui-ai-kit::...>` any single one instead of publishing (and forking) the whole widget:

| Component | View | Renders |
| --- | --- | --- |
| Chatbot | `<x-ui-ai-kit::chatbot />` | The class-based entry point — reads your config defaults, then composes the three below |
| ChatbotWindow | `ui-ai-kit::components.chatbot.window` | The panel: header, message log, suggestions, footnote |
| ChatbotButton | `ui-ai-kit::components.chatbot.button` | The floating launcher icon |
| ChatMessage | `ui-ai-kit::components.chatbot.message` | A single message bubble — takes `role` and `body`, safe to reuse in a loop |
| ChatInput | `ui-ai-kit::components.chatbot.input` | The composer: textarea + send button — takes `name` and `placeholder` |

## Testing

```bash
composer test
composer analyse
composer format
```

## License

MIT. See [LICENSE](LICENSE).
