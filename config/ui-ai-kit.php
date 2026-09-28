<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | Shown in the navigation bar, the footer and the browser title. Set "logo"
    | to a URL or an asset path to replace the generated monogram mark.
    |
    */

    'branding' => [
        'name' => env('UI_AI_KIT_BRAND', 'Laravel UI AI Kit'),
        'monogram' => 'L',
        'logo' => null,
        'logo_fallback' => 'laravel', // laravel | monogram
        'tagline' => 'A landing page and AI assistant you can install with Composer.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | These values are written into the page as CSS custom properties, so you
    | can re-skin the whole UI without publishing or editing any stylesheet.
    | The defaults follow Laravel's own palette.
    |
    */

    'theme' => [
        'mode' => env('UI_AI_KIT_THEME', 'dark'),   // dark | light
        'accent' => env('UI_AI_KIT_ACCENT', '#F53003'),        // Laravel red
        'accent_hover' => env('UI_AI_KIT_ACCENT_HOVER', '#FF4433'),
        'load_fonts' => env('UI_AI_KIT_LOAD_FONTS', true),     // pull Instrument Sans from Google Fonts
        'font_family' => env('UI_AI_KIT_FONT_FAMILY', "'Instrument Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif"),
        'mono_family' => env('UI_AI_KIT_MONO_FAMILY', 'ui-monospace, SFMono-Regular, Menlo, monospace'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Landing Page
    |--------------------------------------------------------------------------
    |
    | Enable or disable the bundled landing page and choose where it lives.
    | Set "enabled" to false if you only want the chatbot component.
    |
    */

    'landing' => [
        'enabled' => env('UI_AI_KIT_LANDING_ENABLED', true),
        'route' => env('UI_AI_KIT_LANDING_ROUTE', 'ui-ai-kit'),
        'middleware' => ['web'],
        'title' => 'Laravel UI AI Kit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Landing Page Content
    |--------------------------------------------------------------------------
    |
    | Every string on the page comes from here, so most projects never need to
    | publish the Blade views. Remove a block (or set it to an empty array) and
    | that section disappears from the page.
    |
    */

    'content' => [

        'sections' => ['hero', 'logos', 'assistant-preview', 'features', 'how-it-works', 'stats', 'pricing', 'testimonials', 'faqs', 'cta'],

        'nav' => [
            ['label' => 'Features', 'href' => '#features'],
            ['label' => 'Assistant preview', 'href' => '#assistant-preview'],
            ['label' => 'How it works', 'href' => '#how-it-works'],
            ['label' => 'Pricing', 'href' => '#pricing'],
            ['label' => 'FAQ', 'href' => '#faq'],
        ],

        'nav_cta' => ['label' => 'Install the kit', 'href' => '#how-it-works'],

        'hero' => [
            'eyebrow' => 'Now on Packagist',
            'heading' => 'A polished landing page and helpful AI chat, built for Laravel.',
            'subheading' => 'Start with a complete, responsive page. Shape every section from config, connect your own AI driver, and deploy it with the Laravel app you already own.',
            'primary_cta' => ['label' => 'See how to install', 'href' => '#how-it-works'],
            'secondary_cta' => ['label' => 'Explore the source', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit'],
            'install_command' => 'composer require shamrozghouri/laravel-ui-ai-kit',
            'notes' => [
                'MIT licensed',
                'Laravel 10+ compatible',
                'No build step required',
            ],
        ],

        'logos' => [
            'label' => 'Built on the tools you already run',
            'items' => ['Laravel', 'Livewire', 'Inertia', 'Tailwind', 'Vite', 'Pest', 'Forge', 'Vapor'],
        ],

        'showcase' => [
            'eyebrow' => 'Meet your AI sidekick',
            'heading' => 'Helpful answers, wrapped in a familiar Laravel feel.',
            'body' => 'Give your customers a friendly place to get unstuck. The assistant lives in your app, speaks from your server-side driver, and picks up your brand along the way.',
            'notes' => [
                'Ground replies in your own documentation',
                'Keep provider keys safely on the server',
                'Match the look and feel of your app',
            ],
            'status' => 'Ready to help',
            'greeting' => 'Hi there! What are you building today?',
            'question' => 'How do I add the assistant to my app?',
            'answer' => 'Add the chatbot component to your Blade layout. That is it. Your provider keys stay safely on the server.',
            'footer_label' => 'A little preview of your assistant',
            'sticker_top' => 'Laravel-ready',
            'sticker_bottom' => 'A little help, a lot of heart',
        ],

        'features' => [
            'heading' => 'What you get in the box',
            'subheading' => 'Practical Laravel tools for polished products and reliable AI agents.',
            'items' => [
                [
                    'title' => 'A landing page that reads from config',
                    'body' => 'Headlines, pricing tiers, testimonials and footer links all live in one config file. Publish the Blade views only when you want to change the structure.',
                ],
                [
                    'title' => 'A chat widget you can drop anywhere',
                    'body' => 'Add one Blade component to your layout. You get the floating button, the window, message history, typing state and error handling.',
                ],
                [
                    'title' => 'Bring your own AI provider',
                    'body' => 'The widget posts to a Laravel route. Swap in OpenAI, Claude, or your own agent by binding a driver — keys stay on the server, never in the browser.',
                ],
                [
                    'title' => 'Plain CSS, no build step',
                    'body' => 'Assets publish straight to your public directory. Nothing to compile, no Node dependency, and the theme is driven by CSS custom properties.',
                ],
                [
                    'title' => 'Laravel Agent Evals',
                    'body' => 'Test your real Laravel AI agent, check expected behavior, save passing baselines, catch regressions, run tagged cases, and export JSON results for CI.',
                    'command' => 'composer require shamrozghouri/laravel-agent-evals',
                ],
            ],
        ],

        'how_it_works' => [
            'heading' => 'From install to live in four steps',
            'steps' => [
                ['title' => 'Require the package', 'body' => 'Laravel discovers the service provider automatically.'],
                ['title' => 'Run the installer', 'body' => 'php artisan ui-ai-kit:install publishes the config and the assets.'],
                ['title' => 'Point it at your AI', 'body' => 'Set an endpoint in config, or bind your own chat driver.'],
                ['title' => 'Customise the copy', 'body' => 'Edit config/ui-ai-kit.php, or publish the views for full control.'],
            ],
        ],

        'stats' => [
            ['value' => '1', 'label' => 'Composer command'],
            ['value' => '0', 'label' => 'Frontend build steps'],
            ['value' => '0', 'label' => 'Blade edits to change copy'],
            ['value' => 'BYO', 'label' => 'AI provider'],
        ],

        'pricing' => [
            'heading' => 'One kit. Pick your starting point.',
            'subheading' => 'Every option is included in the same MIT-licensed package. Start small, then grow into the rest.',
            'footnote' => 'The kit is free. Hosting and any AI provider usage are billed separately by your chosen services.',
            'featured_label' => 'Most popular',
            'tiers' => [
                [
                    'variant' => 'page',
                    'eyebrow' => 'For your next launch',
                    'name' => 'The landing page',
                    'price' => '$0',
                    'period' => 'forever',
                    'description' => 'Give your offer a polished, responsive home that feels like your brand.',
                    'cta' => ['label' => 'Explore page sections', 'href' => '#features'],
                    'featured' => false,
                    'features' => [
                        ['label' => 'Config-driven page sections', 'included' => true],
                        ['label' => 'Light and dark themes', 'included' => true],
                        ['label' => 'FAQs, pricing and lead form', 'included' => true],
                        ['label' => 'Runs inside your Laravel app', 'included' => true],
                    ],
                ],
                [
                    'variant' => 'assistant',
                    'eyebrow' => 'For a better customer experience',
                    'name' => 'Page + AI assistant',
                    'price' => '$0',
                    'period' => 'forever',
                    'description' => 'Pair your landing page with an assistant that can answer questions.',
                    'cta' => ['label' => 'Install the full kit', 'href' => 'https://packagist.org/packages/shamrozghouri/laravel-ui-ai-kit'],
                    'featured' => true,
                    'features' => [
                        ['label' => 'Everything in the landing page', 'included' => true],
                        ['label' => 'Drop-in chat widget', 'included' => true],
                        ['label' => 'Bring your own AI driver', 'included' => true],
                        ['label' => 'Keep provider keys server-side', 'included' => true],
                    ],
                ],
                [
                    'variant' => 'agency',
                    'eyebrow' => 'For freelancers and studios',
                    'name' => 'Client projects',
                    'price' => '$0',
                    'period' => 'per project',
                    'description' => 'Start each client site with a reusable, brandable Laravel foundation.',
                    'cta' => ['label' => 'See the MIT license', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/blob/main/LICENSE'],
                    'featured' => false,
                    'features' => [
                        ['label' => 'Commercial use permitted', 'included' => true],
                        ['label' => 'Rebrand each installation', 'included' => true],
                        ['label' => 'Reorder or hide sections', 'included' => true],
                        ['label' => 'Own and customize the code', 'included' => true],
                    ],
                ],
            ],
        ],

        'testimonials' => [
            'heading' => 'Built by Shamroz Ghouri',
            'subheading' => 'The idea, approach, and developer behind Laravel UI AI Kit.',
            'items' => [
                [
                    'quote' => 'I built Laravel UI AI Kit to give Laravel developers a polished landing page and AI assistant without rebuilding the same interface for every project.',
                    'name' => 'Shamroz Ghouri',
                    'role' => 'Creator, Laravel UI AI Kit',
                ],
                [
                    'quote' => 'My goal is to keep setup familiar: install with Composer, choose the experience you need, and customize the product from one configuration file.',
                    'name' => 'Shamroz Ghouri',
                    'role' => 'Laravel Package Developer',
                ],
                [
                    'quote' => 'I designed the package so teams can connect their own AI provider while keeping credentials and application logic safely on the Laravel server.',
                    'name' => 'Shamroz Ghouri',
                    'role' => 'Open-source Maintainer',
                ],
            ],
        ],

        'faqs' => [
            'heading' => 'Good questions. Straight answers.',
            'subheading' => 'The practical details before you install.',
            'items' => [
                [
                    'question' => 'Does this add a JavaScript build tool to my Laravel app?',
                    'answer' => 'No. The package ships its own CSS and JavaScript. The optional 3D hero loads a pinned Three.js file only when the hero is near the viewport; if it cannot load, a lightweight CSS illustration remains.',
                ],
                [
                    'question' => 'Can I change the page for my product or business?',
                    'answer' => 'Yes. Edit the content, section order, brand, logo and theme in config/ui-ai-kit.php. Every section can be hidden or reordered. Publish the views only when you need to change their markup.',
                ],
                [
                    'question' => 'Which AI provider do I need?',
                    'answer' => 'The chatbot uses a server-side driver contract. Use the included local driver to try the widget, then connect your provider or bind your own driver. Provider secrets stay on the server.',
                ],
                [
                    'question' => 'What does the kit cost?',
                    'answer' => 'The package is MIT licensed and has no package subscription fee. Your Laravel hosting and any AI provider usage are separate costs.',
                ],
                [
                    'question' => 'Can I use this for client projects?',
                    'answer' => 'Yes. The MIT license allows commercial use. Configure each project with its own brand, copy, links, pricing, FAQs and sections.',
                ],
            ],
        ],

        'cta' => [
            'heading' => 'Build a page that feels like your business.',
            'body' => 'Start with a real Laravel package. Keep the sections you need, connect your own tools, and make the copy yours.',
            'primary' => ['label' => 'Install from Packagist', 'href' => 'https://packagist.org/packages/shamrozghouri/laravel-ui-ai-kit'],
            'secondary' => ['label' => 'Browse the source', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit'],
            'form' => null,
        ],

        'footer' => [
            'blurb' => 'An open source landing page and chatbot UI for Laravel.',
            'columns' => [
                [
                    'title' => 'Package',
                    'links' => [
                        ['label' => 'Installation', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit#installation'],
                        ['label' => 'Configuration', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit#configuration'],
                        ['label' => 'Blade components', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit#chatbot'],
                        ['label' => 'Changelog', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/blob/main/CHANGELOG.md'],
                    ],
                ],
                [
                    'title' => 'Project',
                    'links' => [
                        ['label' => 'GitHub', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit'],
                        ['label' => 'Packagist', 'href' => 'https://packagist.org/packages/shamrozghouri/laravel-ui-ai-kit'],
                        ['label' => 'Issues', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/issues'],
                        ['label' => 'Contributing', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/issues'],
                    ],
                ],
                [
                    'title' => 'More',
                    'links' => [
                        ['label' => 'Security', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/security'],
                        ['label' => 'License', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit/blob/main/LICENSE'],
                        ['label' => 'Credits', 'href' => 'https://github.com/shamrozghouri/laravel-ui-ai-kit'],
                    ],
                ],
            ],
            'copyright' => '© '.date('Y').' Laravel UI AI Kit. Released under the MIT license.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatbot
    |--------------------------------------------------------------------------
    */

    'chatbot' => [
        'enabled' => env('UI_AI_KIT_CHATBOT_ENABLED', true),
        'name' => env('UI_AI_KIT_CHATBOT_NAME', 'AI Assistant'),
        'subtitle' => env('UI_AI_KIT_CHATBOT_SUBTITLE', 'Usually replies instantly'),
        'welcome_message' => 'Hi. Ask me anything about the package and I will try to help.',
        'empty_message' => 'Ask a question to get started.',
        'footnote' => 'Answers are generated and may be wrong.',
        'placeholder' => 'Type your message',
        'open_label' => 'Open :name',
        'close_label' => 'Close :name',
        'send_label' => 'Send message',
        'position' => 'bottom-right',        // bottom-right | bottom-left

        // Overrides the header icon. Accepts an image URL/path (png, jpg,
        // gif, svg, webp, or a data: URI) or a short piece of text/an emoji
        // (e.g. "🤖"). Leave null to keep the default icon.
        'avatar' => env('UI_AI_KIT_CHATBOT_AVATAR'),

        'open_on_load' => false,
        'layout' => [
            'width' => '380px',
            'height' => '560px',
            'offset' => '24px',
        ],
        'suggestions' => [
            'How do I install it?',
            'Can I use my own AI provider?',
            'How do I change the colours?',
        ],
        'error_message' => 'That message did not go through. Try again.',
        'max_length' => 2000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Console (full-page chatbot UI)
    |--------------------------------------------------------------------------
    |
    | A full-screen, dashboard-style chat experience — sidebar navigation,
    | header, message thread and a right-hand info panel — as an alternative
    | to the floating widget above. Visit the "route" below to see it.
    |
    */

    'console' => [
        'enabled' => env('UI_AI_KIT_CONSOLE_ENABLED', true),
        'route' => env('UI_AI_KIT_CONSOLE_ROUTE', 'ui-ai-kit/console'),
        'middleware' => ['web'],
        'title' => env('UI_AI_KIT_CONSOLE_TITLE', 'LaravelBot — Console'),

        // Toggle whole regions on or off — handy when you're embedding the
        // console inside an app that already has its own sidebar or header.
        'layout' => [
            'show_sidebar' => env('UI_AI_KIT_CONSOLE_SIDEBAR', true),
            'show_panel' => env('UI_AI_KIT_CONSOLE_PANEL', true),
            'show_header' => env('UI_AI_KIT_CONSOLE_HEADER', true),
        ],

        'brand' => [
            'name' => env('UI_AI_KIT_CONSOLE_NAME', 'LaravelBot'),
            // The trailing portion of "name" that renders in the accent colour.
            'name_accent' => env('UI_AI_KIT_CONSOLE_NAME_ACCENT', 'Bot'),
            'tagline' => env('UI_AI_KIT_CONSOLE_TAGLINE', 'Your Laravel Assistant in the Cloud'),
            'header_subtitle' => env('UI_AI_KIT_CONSOLE_HEADER_SUBTITLE', 'Cloud Powered Laravel Chatbot'),
            'footer_tagline' => env('UI_AI_KIT_CONSOLE_FOOTER_TAGLINE', 'Build. Deploy. Grow. With Laravel.'),
            // Optional logo URL or asset path. Falls back to the drawn shield
            // mark (and, if unset, to the shared "branding.logo" above) when null.
            'logo' => env('UI_AI_KIT_CONSOLE_LOGO', null),
        ],

        // Every item here becomes a sidebar link. Add, remove, or reorder
        // freely — icons are one of: chat, dashboard, book, settings,
        // history, terminal, rocket. Set "active" on the current page.
        'nav' => [
            ['label' => 'Chat', 'icon' => 'chat', 'href' => '#', 'active' => true],
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => '#'],
            ['label' => 'Knowledge Base', 'icon' => 'book', 'href' => '#'],
            ['label' => 'Settings', 'icon' => 'settings', 'href' => '#'],
            ['label' => 'History', 'icon' => 'history', 'href' => '#'],
        ],

        'user' => [
            'name' => env('UI_AI_KIT_CONSOLE_USER_NAME', 'Admin'),
            'initial' => env('UI_AI_KIT_CONSOLE_USER_INITIAL', 'A'),
            'status' => env('UI_AI_KIT_CONSOLE_USER_STATUS', 'Online'),
        ],

        'welcome_message' => env(
            'UI_AI_KIT_CONSOLE_WELCOME',
            "Hello! I'm LaravelBot, your AI assistant powered by Laravel.\nAsk me anything about Laravel, PHP, or web development!"
        ),

        'placeholder' => env('UI_AI_KIT_CONSOLE_PLACEHOLDER', 'Type your message...'),

        'about' => [
            'heading' => env('UI_AI_KIT_CONSOLE_ABOUT_HEADING', 'LaravelBot'),
            'subheading' => env('UI_AI_KIT_CONSOLE_ABOUT_SUBHEADING', 'Powered by Laravel & Cloud'),
            'body' => env(
                'UI_AI_KIT_CONSOLE_ABOUT_BODY',
                "Get instant help with Laravel, PHP, web development, and more. I'm always here to assist you!"
            ),
        ],

        // Each action fills the composer with "prompt" and sends it. Leave
        // "prompt" empty to just focus the input instead (see "Ask a
        // Question" below). Icons use the same set as "nav" above.
        'quick_actions' => [
            ['label' => 'Laravel Documentation', 'icon' => 'book', 'prompt' => 'Where can I find the Laravel documentation?'],
            ['label' => 'Common Commands', 'icon' => 'terminal', 'prompt' => 'What are some common Artisan commands?'],
            ['label' => 'Project Setup Guide', 'icon' => 'rocket', 'prompt' => 'Walk me through setting up a new Laravel project.'],
            ['label' => 'Ask a Question', 'icon' => 'chat', 'prompt' => ''],
        ],

        // Set to null (or an empty array) to hide the promo card entirely.
        'promo' => [
            'heading' => env('UI_AI_KIT_CONSOLE_PROMO_HEADING', 'Running in the Cloud'),
            'body' => env('UI_AI_KIT_CONSOLE_PROMO_BODY', 'Powered by Laravel'),
        ],

        'footer' => [
            'heading' => env('UI_AI_KIT_CONSOLE_FOOTER_HEADING', 'LaravelBot'),
            'tagline' => env('UI_AI_KIT_CONSOLE_FOOTER_TAGLINE_SMALL', 'Always here, in the cloud.'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Full-page ChatGPT-style interface
    |--------------------------------------------------------------------------
    */

    'chat_page' => [
        'enabled' => env('UI_AI_KIT_CHAT_PAGE_ENABLED', false),
        'route' => env('UI_AI_KIT_CHAT_PAGE_ROUTE', 'ui-ai-kit/assistant'),
        'middleware' => ['web'],
        'title' => env('UI_AI_KIT_CHAT_PAGE_TITLE', 'Laravel AI Assistant'),
        'heading' => 'How can Laravel help you?',
        'subheading' => 'Ask about Laravel, your code, or what you are building.',
        'history_limit' => 30,
        'suggestions' => [
            [
                'title' => 'About the creator',
                'prompt' => 'Who is Shamroz Ghouri, and what does he build?',
                'answer' => 'Shamroz Ghouri is the creator of Laravel UI AI Kit and Laravel Agent Evals. He builds practical open-source Laravel packages for polished interfaces, AI integration, and reliable AI-agent testing.',
            ],
            [
                'title' => 'Laravel Agent Evals',
                'prompt' => 'What does Laravel Agent Evals do?',
                'answer' => 'Laravel Agent Evals tests your real Laravel AI agent. It checks expected behavior, saves passing baselines, catches regressions, runs tagged cases, and exports JSON for CI. Install it with `composer require shamrozghouri/laravel-agent-evals`.',
            ],
            [
                'title' => 'Install the package',
                'prompt' => 'Show me the complete Laravel UI AI Kit installation steps, including composer require and the Artisan install wizard.',
                'answer' => 'From your Laravel project directory, run `composer require shamrozghouri/laravel-ui-ai-kit`, then `php artisan ui-ai-kit:install`. Choose Full landing page or Full chatbot interface when prompted. The command publishes `config/ui-ai-kit.php` and assets. Composer itself cannot run package prompts, so run the Artisan command after Composer finishes.',
            ],
            [
                'title' => 'Choose my home page',
                'prompt' => 'How do I choose the full landing page or full chatbot interface as my Laravel app home page? Include the interactive and --experience install commands.',
                'answer' => 'Run `php artisan ui-ai-kit:install` and choose Full landing page or Full chatbot interface. For automation, use `php artisan ui-ai-kit:install --no-wizard --experience=landing` or `php artisan ui-ai-kit:install --no-wizard --experience=chat`. The selected page is mounted at `/`; the other home-page route is disabled. Run `php artisan config:clear` if your app caches config.',
            ],
            [
                'title' => 'Customize the landing page',
                'prompt' => 'Explain how to edit landing-page copy, section order, pricing, FAQs, and branding in config/ui-ai-kit.php, and when to publish the landing views.',
                'answer' => 'Edit `config/ui-ai-kit.php`: set the brand in `branding`, copy/pricing/FAQ content in `content`, and order or remove sections with `content.sections`. For markup changes, run `php artisan vendor:publish --tag=ui-ai-kit-views`; edit the app-owned files under `resources/views/vendor/ui-ai-kit/`. Clear cached config after changing configuration.',
            ],
            [
                'title' => 'Customize the chatbot UI',
                'prompt' => 'Show me how to customize the full chatbot interface layout, starter prompts, logo, colors, typography, and Blade views without editing vendor files.',
                'answer' => 'Edit `chat_page.heading`, `chat_page.subheading`, and `chat_page.suggestions` in `config/ui-ai-kit.php` for the welcome screen and starter cards. Use `branding`, `chatbot`, and `theme` for logo, assistant name, colors, fonts, and light/dark mode. For markup, run `php artisan vendor:publish --tag=ui-ai-kit-chatbot-views`, then edit `resources/views/vendor/ui-ai-kit/chat-page/index.blade.php` and your published `public/vendor/ui-ai-kit/css/chat.css`. Do not edit `vendor/`.',
            ],
            [
                'title' => 'Set up themes and branding',
                'prompt' => 'How do I configure the logo, Laravel mark fallback, accent colors, fonts, and light or dark theme for the landing page and chatbot?',
                'answer' => 'In `config/ui-ai-kit.php`, set `branding.name`, `branding.logo`, and `branding.logo_fallback`; customize `theme.mode`, `theme.accent`, `theme.accent_hover`, `theme.font_family`, and `theme.mono_family`. The landing and full chat pages have light/dark toggles. Run `php artisan config:clear` after editing cached config.',
            ],
            [
                'title' => 'Widget, full chat, or console?',
                'prompt' => 'Explain the differences between the floating chatbot widget, full-page ChatGPT-style interface, and dashboard console, including how to enable and route each one.',
                'answer' => 'The floating widget is `<x-ui-ai-kit::chatbot />` for embedding in any Blade layout. The full-page ChatGPT-style interface is configured by `chat_page.enabled` and `chat_page.route`; the installer can select it as `/`. The separate dashboard console uses `console.enabled` and `console.route`. Pick landing or full chat in the installer for the main home experience.',
            ],
            [
                'title' => 'Connect my AI provider',
                'prompt' => 'Explain the echo, forward, and custom ChatDriver options, how to connect my AI provider, and where provider API keys should be stored.',
                'answer' => 'The `echo` driver is only a local demo. To connect your service, set `UI_AI_KIT_CHAT_DRIVER=forward` and `UI_AI_KIT_CHAT_ENDPOINT=https://your-app.example/api/chat` in `.env`, or rerun `php artisan ui-ai-kit:install` and choose forward when asked for a driver. The package POSTs JSON with `message`, `conversation_id`, and `history`. Your endpoint must return JSON with `message` (or `reply`) and may return `conversation_id`. Add authorization headers under `api.headers` in `config/ui-ai-kit.php`; keep secrets server-side and run `php artisan config:clear` after config changes. For a custom provider, implement `ChatDriver` and register it with `ChatManager::extend()`.',
            ],
            [
                'title' => 'Understand chat history and API',
                'prompt' => 'Explain the chat endpoint, request and response fields, CSRF protection, browser-local conversation history, and how I can add server-side persistence.',
                'answer' => 'The UI sends a CSRF-protected POST to `api.route` with `message`, `conversation_id`, and recent `history`; it expects JSON containing `message` or `reply`, plus an optional `conversation_id`. Full-page chat history is stored in this browser local storage, not your database. To share history across devices, add persistence to your Laravel backend/ChatDriver and customize the chat page to load and save server records.',
            ],
            [
                'title' => 'Publish views and assets',
                'prompt' => 'Give me the exact Artisan commands and destination paths for publishing chatbot views, all package views, and CSS or JavaScript assets safely.',
                'answer' => 'For chat/console views run `php artisan vendor:publish --tag=ui-ai-kit-chatbot-views`; edit `resources/views/vendor/ui-ai-kit/chat-page/` and `resources/views/vendor/ui-ai-kit/console/`. For every Blade view use `php artisan vendor:publish --tag=ui-ai-kit-views`. For CSS/JS run `php artisan vendor:publish --tag=ui-ai-kit-assets`; files go under `public/vendor/ui-ai-kit/`. Customize these app-owned copies, never `/vendor`. Publishing assets again with `--force` overwrites your edits.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chat API
    |--------------------------------------------------------------------------
    |
    | The widget posts to "route" below. The "driver" decides what happens
    | next: "echo" replies locally (useful before you wire anything up),
    | "forward" proxies the message to "endpoint" server-side, and you can
    | register your own driver from a service provider.
    |
    */

    'api' => [
        'enabled' => true,
        'route' => env('UI_AI_KIT_CHAT_ROUTE', 'ui-ai-kit/chat'),
        'middleware' => ['web'],
        'throttle' => env('UI_AI_KIT_CHAT_THROTTLE', '20,1'),  // requests,minutes — null to disable
        'driver' => env('UI_AI_KIT_CHAT_DRIVER', 'echo'),      // echo | forward | custom binding
        'endpoint' => env('UI_AI_KIT_CHAT_ENDPOINT'),
        'timeout' => 30,
        'headers' => [
            // 'Authorization' => 'Bearer '.env('UI_AI_KIT_CHAT_TOKEN'),
        ],
    ],
];
