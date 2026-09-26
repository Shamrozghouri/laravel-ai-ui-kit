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

        'nav' => [
            ['label' => 'Features', 'href' => '#features'],
            ['label' => 'How it works', 'href' => '#how-it-works'],
            ['label' => 'Pricing', 'href' => '#pricing'],
            ['label' => 'Reviews', 'href' => '#reviews'],
        ],

        'nav_cta' => ['label' => 'Get started', 'href' => '#pricing'],

        'hero' => [
            'eyebrow' => 'Now on Packagist',
            'heading' => 'Ship a landing page and an AI assistant in one command.',
            'subheading' => 'Install the package, publish the config, and your Laravel app has a production-ready marketing page plus a chat widget wired to whichever AI provider you already use.',
            'primary_cta' => ['label' => 'Read the docs', 'href' => '#features'],
            'secondary_cta' => ['label' => 'View on GitHub', 'href' => '#'],
            'install_command' => 'composer require shamrozghouri/laravel-ui-ai-kit',
            'notes' => [
                'MIT licensed',
                'Laravel 10, 11 and 12',
                'No build step required',
            ],
        ],

        'logos' => [
            'label' => 'Built on the tools you already run',
            'items' => ['Laravel', 'Livewire', 'Inertia', 'Tailwind', 'Vite', 'Pest', 'Forge', 'Vapor'],
        ],

        'features' => [
            'heading' => 'What you get in the box',
            'subheading' => 'Four pieces that would otherwise take a week of setup.',
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
            ['value' => '0', 'label' => 'Node dependencies'],
            ['value' => '3', 'label' => 'Laravel versions supported'],
            ['value' => '12kb', 'label' => 'Gzipped CSS and JS'],
        ],

        'pricing' => [
            'heading' => 'Free, and paid where it saves you time',
            'subheading' => 'The package is MIT. Support and premium themes are optional.',
            'tiers' => [
                [
                    'name' => 'Open source',
                    'price' => '$0',
                    'period' => 'forever',
                    'description' => 'The whole package, MIT licensed.',
                    'cta' => ['label' => 'Install now', 'href' => '#'],
                    'featured' => false,
                    'features' => [
                        ['label' => 'Landing page and chatbot', 'included' => true],
                        ['label' => 'Config-driven content', 'included' => true],
                        ['label' => 'Community issues', 'included' => true],
                        ['label' => 'Premium themes', 'included' => false],
                    ],
                ],
                [
                    'name' => 'Studio',
                    'price' => '$49',
                    'period' => 'one-off',
                    'description' => 'Extra themes and component variants.',
                    'cta' => ['label' => 'Buy Studio', 'href' => '#'],
                    'featured' => true,
                    'features' => [
                        ['label' => 'Everything in Open source', 'included' => true],
                        ['label' => 'Six additional themes', 'included' => true],
                        ['label' => 'Alternative hero layouts', 'included' => true],
                        ['label' => 'Priority issue triage', 'included' => true],
                    ],
                ],
                [
                    'name' => 'Team',
                    'price' => '$199',
                    'period' => 'per year',
                    'description' => 'For agencies shipping this to clients.',
                    'cta' => ['label' => 'Talk to us', 'href' => '#'],
                    'featured' => false,
                    'features' => [
                        ['label' => 'Everything in Studio', 'included' => true],
                        ['label' => 'Unlimited client projects', 'included' => true],
                        ['label' => 'Private support channel', 'included' => true],
                        ['label' => 'Migration help', 'included' => true],
                    ],
                ],
            ],
        ],

        'testimonials' => [
            'heading' => 'What developers say',
            'items' => [
                [
                    'quote' => 'I had the chat widget answering questions against our own docs endpoint before lunch. The driver contract is the part that made it easy.',
                    'name' => 'Maya Rodriguez',
                    'role' => 'Backend lead, Cartwheel',
                ],
                [
                    'quote' => 'We drop this into every client project now. Editing one config file beats rebuilding a marketing page from scratch every time.',
                    'name' => 'James Chen',
                    'role' => 'Founder, Ninefold Studio',
                ],
                [
                    'quote' => 'No Node, no build step, and it still looks like it belongs next to the rest of our Laravel app. That was the selling point.',
                    'name' => 'Sarah Kim',
                    'role' => 'Engineer, Halcyon',
                ],
            ],
        ],

        'cta' => [
            'heading' => 'Add it to your next Laravel project',
            'body' => 'One command, then decide how much of it you want to keep.',
            'primary' => ['label' => 'Get started', 'href' => '#'],
            'secondary' => ['label' => 'Browse the source', 'href' => '#'],
        ],

        'footer' => [
            'blurb' => 'An open source landing page and chatbot UI for Laravel.',
            'columns' => [
                [
                    'title' => 'Package',
                    'links' => [
                        ['label' => 'Installation', 'href' => '#'],
                        ['label' => 'Configuration', 'href' => '#'],
                        ['label' => 'Blade components', 'href' => '#'],
                        ['label' => 'Changelog', 'href' => '#'],
                    ],
                ],
                [
                    'title' => 'Project',
                    'links' => [
                        ['label' => 'GitHub', 'href' => '#'],
                        ['label' => 'Packagist', 'href' => '#'],
                        ['label' => 'Issues', 'href' => '#'],
                        ['label' => 'Contributing', 'href' => '#'],
                    ],
                ],
                [
                    'title' => 'More',
                    'links' => [
                        ['label' => 'Security', 'href' => '#'],
                        ['label' => 'License', 'href' => '#'],
                        ['label' => 'Credits', 'href' => '#'],
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
        'subtitle' => 'Usually replies instantly',
        'welcome_message' => 'Hi. Ask me anything about the package and I will try to help.',
        'placeholder' => 'Type your message',
        'position' => 'bottom-right',        // bottom-right | bottom-left

        // Overrides the header icon. Accepts an image URL/path (png, jpg,
        // gif, svg, webp, or a data: URI) or a short piece of text/an emoji
        // (e.g. "🤖"). Leave null to keep the default icon.
        'avatar' => env('UI_AI_KIT_CHATBOT_AVATAR'),

        'open_on_load' => false,
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
