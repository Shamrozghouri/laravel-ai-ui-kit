<?php

namespace Shamrozghouri\LaravelUiAiKit;

class UiAiKit
{
    protected static bool $assetsRendered = false;

    /**
     * Stylesheet and script tags for the widget, emitted only once per request
     * so a page that uses both the landing layout and the component does not
     * load them twice.
     */
    public static function assetTags(): string
    {
        if (static::$assetsRendered) {
            return '';
        }

        static::$assetsRendered = true;

        return '<link rel="stylesheet" href="'.e(static::asset('css/ui-ai-kit.css')).'">'
            .'<script src="'.e(static::asset('js/chatbot.js')).'" defer></script>';
    }

    /**
     * Reset between requests. Called from the service provider in long-running
     * workers such as Octane.
     */
    public static function flush(): void
    {
        static::$assetsRendered = false;
    }

    /**
     * URL for a package asset. Prefers the copy in public/vendor/ui-ai-kit when the
     * assets have been published, and falls back to serving from the package.
     */
    public static function asset(string $file): string
    {
        $published = public_path('vendor/ui-ai-kit/'.$file);

        if (is_file($published)) {
            return asset('vendor/ui-ai-kit/'.$file).'?v='.substr((string) filemtime($published), -6);
        }

        return url('ui-ai-kit/assets/'.basename($file));
    }

    /**
     * CSS custom properties built from the configured theme.
     */
    public static function themeVariables(): string
    {
        $theme = (array) config('ui-ai-kit.theme', []);

        $vars = [
            '--uiaikit-accent' => filled($theme['accent'] ?? null) ? $theme['accent'] : '#F53003',
            '--uiaikit-accent-hover' => filled($theme['accent_hover'] ?? null) ? $theme['accent_hover'] : '#FF4433',
            '--uiaikit-font' => filled($theme['font_family'] ?? null) ? $theme['font_family'] : 'ui-sans-serif, system-ui, sans-serif',
            '--uiaikit-mono' => filled($theme['mono_family'] ?? null) ? $theme['mono_family'] : 'ui-monospace, SFMono-Regular, Menlo, monospace',
        ];

        return implode('', array_map(
            fn ($key, $value) => $key.':'.$value.';',
            array_keys($vars),
            $vars
        ));
    }
}
