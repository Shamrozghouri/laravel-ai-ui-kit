<?php

namespace Shamrozghouri\LaravelUiAiKit\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'ui-ai-kit:install
        {--force : Overwrite files that already exist}
        {--no-wizard : Skip the interactive setup questions and just publish defaults}';

    protected $description = 'Publish the Laravel UI AI Kit configuration and assets, and optionally customise them';

    /** @var array<string, string> */
    protected array $env = [];

    public function handle(): int
    {
        $this->components->info('Installing Laravel UI AI Kit');

        $this->callSilently('vendor:publish', array_filter([
            '--tag' => 'ui-ai-kit-config',
            '--force' => $this->option('force'),
        ]));
        $this->components->task('Configuration published to config/ui-ai-kit.php');

        $this->callSilently('vendor:publish', array_filter([
            '--tag' => 'ui-ai-kit-assets',
            '--force' => $this->option('force'),
        ]));
        $this->components->task('Assets published to public/vendor/ui-ai-kit');

        if (! $this->option('no-wizard') && $this->input->isInteractive()) {
            $this->runWizard();
        }

        $this->newLine();
        $this->components->bulletList([
            'Landing page: /'.config('ui-ai-kit.landing.route', 'ui-ai-kit'),
            'Full-page console: /'.config('ui-ai-kit.console.route', 'ui-ai-kit/console'),
            'Add <x-ui-ai-kit::chatbot /> before </body> in your layout for the floating widget',
            'Point ui-ai-kit.api at your AI provider when you are ready',
            'Re-run "php artisan ui-ai-kit:install" any time to change these answers',
        ]);

        return self::SUCCESS;
    }

    /**
     * Ask a handful of short questions and write the answers to .env, so a
     * fresh install can be branded without hand-editing the config file.
     */
    protected function runWizard(): void
    {
        $this->newLine();
        $this->components->info('Quick setup — press Enter to keep any default');

        $this->env['UI_AI_KIT_CONSOLE_NAME'] = (string) $this->ask(
            'What should the assistant be called?',
            config('ui-ai-kit.console.brand.name', 'LaravelBot')
        );

        $this->env['UI_AI_KIT_CONSOLE_TAGLINE'] = (string) $this->ask(
            'Short tagline for the sidebar',
            config('ui-ai-kit.console.brand.tagline', 'Your Laravel Assistant in the Cloud')
        );

        $this->env['UI_AI_KIT_ACCENT'] = (string) $this->ask(
            'Accent colour (hex)',
            config('ui-ai-kit.theme.accent', '#F53003')
        );

        $mode = $this->choice(
            'Colour mode',
            ['dark', 'light'],
            config('ui-ai-kit.theme.mode', 'dark') === 'light' ? 1 : 0
        );
        $this->env['UI_AI_KIT_THEME'] = $mode;

        $wantsConsole = $this->confirm(
            'Enable the full-page console UI (in addition to the floating widget)?',
            config('ui-ai-kit.console.enabled', true)
        );
        $this->env['UI_AI_KIT_CONSOLE_ENABLED'] = $wantsConsole ? 'true' : 'false';

        if ($wantsConsole) {
            $this->env['UI_AI_KIT_CONSOLE_ROUTE'] = (string) $this->ask(
                'Console route',
                config('ui-ai-kit.console.route', 'ui-ai-kit/console')
            );
        }

        $wantsWidget = $this->confirm(
            'Enable the floating chat widget?',
            config('ui-ai-kit.chatbot.enabled', true)
        );
        $this->env['UI_AI_KIT_CHATBOT_ENABLED'] = $wantsWidget ? 'true' : 'false';

        $driver = $this->choice(
            'How should chat messages be answered for now?',
            ['echo (repeats the message back, good for testing)', 'forward (proxy to an HTTP endpoint you provide)'],
            0
        );
        $this->env['UI_AI_KIT_CHAT_DRIVER'] = str_starts_with($driver, 'echo') ? 'echo' : 'forward';

        if ($this->env['UI_AI_KIT_CHAT_DRIVER'] === 'forward') {
            $this->env['UI_AI_KIT_CHAT_ENDPOINT'] = (string) $this->ask(
                'Endpoint to forward chat messages to',
                config('ui-ai-kit.api.endpoint', '')
            );
        }

        $this->writeEnv();
    }

    /**
     * Write (or update) the collected keys in the application's .env file.
     * Existing unrelated lines are left untouched.
     */
    protected function writeEnv(): void
    {
        $path = base_path('.env');

        if (! is_file($path)) {
            $this->components->warn('.env file not found — skipping. Set these manually:');
            foreach ($this->env as $key => $value) {
                $this->line("  {$key}=".$this->envValue($value));
            }

            return;
        }

        $contents = (string) file_get_contents($path);

        foreach ($this->env as $key => $value) {
            $line = $key.'='.$this->envValue($value);
            $pattern = '/^'.preg_quote($key, '/').'=.*/m';

            $contents = preg_match($pattern, $contents) === 1
                ? (string) preg_replace($pattern, $line, $contents)
                : rtrim($contents)."\n".$line."\n";
        }

        file_put_contents($path, $contents);

        $this->components->task('Preferences saved to .env');
    }

    protected function envValue(string $value): string
    {
        return preg_match('/\s/', $value) === 1 ? '"'.addslashes($value).'"' : $value;
    }
}
