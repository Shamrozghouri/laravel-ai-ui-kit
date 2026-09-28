<?php

namespace Shamrozghouri\LaravelUiAiKit\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'ui-ai-kit:install
        {--force : Overwrite files that already exist}
        {--no-wizard : Skip the interactive setup questions and just publish defaults}
        {--experience= : Select the app home page without prompting: landing or chat}';

    protected $description = 'Publish the Laravel UI AI Kit configuration and assets, and optionally customise them';

    /** @var array<string, string> */
    protected array $env = [];

    protected ?string $customDriverClass = null;

    protected ?string $homeExperience = null;

    public function handle(): int
    {
        $this->components->info('Installing Laravel UI AI Kit');
        $experience = $this->option('experience');
        if ($experience !== null && ! in_array($experience, ['landing', 'chat'], true)) {
            $this->components->error('The --experience option must be "landing" or "chat".');

            return self::FAILURE;
        }

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

        if ($experience !== null) {
            $this->setHomeExperience($experience);
        }

        if (! $this->option('no-wizard') && $this->input->isInteractive()) {
            $this->runWizard($experience === null);
        } elseif ($experience !== null) {
            $this->writeEnv();
        }

        $this->newLine();
        $this->components->bulletList(array_filter([
            $this->homeExperience === 'chat'
                ? 'Selected home page: full chatbot interface at /'
                : ($this->homeExperience === 'landing' ? 'Selected home page: full landing page at /' : null),
            $this->homeExperience === null ? 'Landing page: /'.config('ui-ai-kit.landing.route', 'ui-ai-kit') : null,
            'Add <x-ui-ai-kit::chatbot /> before </body> in your layout for the floating widget',
            'Publish editable chatbot/console views with "php artisan vendor:publish --tag=ui-ai-kit-chatbot-views"',
            $this->customDriverClass
                ? "Register your driver — add this to a service provider's boot(): app(\Shamrozghouri\LaravelUiAiKit\Services\ChatManager::class)->extend('custom', fn () => new \App\UiAiKit\\{$this->customDriverClass});"
                : 'Point ui-ai-kit.api at your AI provider when you are ready',
            'Re-run "php artisan ui-ai-kit:install" any time to change these answers',
        ]));

        return self::SUCCESS;
    }

    /**
     * Ask a handful of short questions and write the answers to .env, so a
     * fresh install can be branded without hand-editing the config file.
     */
    protected function runWizard(bool $askHomeExperience = true): void
    {
        if ($askHomeExperience) {
            $this->newLine();
            $this->components->info('Choose which complete experience should be your app home page.');

            $choice = $this->choice(
                'Which UI should open at /?',
                ['Full landing page', 'Full chatbot interface'],
                0
            );
            $this->setHomeExperience(str_starts_with($choice, 'Full chatbot') ? 'chat' : 'landing');
        }

        $this->newLine();
        $this->components->info('Optional design and backend setup — press Enter to keep defaults');

        $assistantName = (string) $this->ask(
            'What should the Laravel assistant be called?',
            config('ui-ai-kit.chatbot.name', 'Laravel Assistant')
        );
        $this->env['UI_AI_KIT_CHATBOT_NAME'] = $assistantName;
        $this->env['UI_AI_KIT_CONSOLE_NAME'] = $assistantName;

        $subtitle = (string) $this->ask(
            'Short subtitle for the assistant',
            config('ui-ai-kit.chatbot.subtitle', 'Your Laravel coding companion')
        );
        $this->env['UI_AI_KIT_CHATBOT_SUBTITLE'] = $subtitle;
        $this->env['UI_AI_KIT_CONSOLE_TAGLINE'] = $subtitle;

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

        $wantsWidget = $this->confirm(
            'Also enable the floating chat widget?',
            $this->homeExperience === 'landing'
        );
        $this->env['UI_AI_KIT_CHATBOT_ENABLED'] = $wantsWidget ? 'true' : 'false';

        $driver = $this->choice(
            'How should chat messages be answered for now?',
            [
                'echo (repeats the message back, good for testing)',
                'forward (proxy to an HTTP endpoint you provide)',
                'custom (generate a driver class stub in your app)',
            ],
            0
        );

        if (str_starts_with($driver, 'echo')) {
            $this->env['UI_AI_KIT_CHAT_DRIVER'] = 'echo';
        } elseif (str_starts_with($driver, 'forward')) {
            $this->env['UI_AI_KIT_CHAT_DRIVER'] = 'forward';
            $this->env['UI_AI_KIT_CHAT_ENDPOINT'] = (string) $this->ask(
                'Endpoint to forward chat messages to',
                config('ui-ai-kit.api.endpoint', '')
            );
        } else {
            $this->env['UI_AI_KIT_CHAT_DRIVER'] = 'custom';

            $class = (string) $this->ask('Class name for your driver', 'CustomChatDriver');
            $this->generateDriverStub($class);
        }

        $this->writeEnv();
    }

    protected function setHomeExperience(string $experience): void
    {
        $this->homeExperience = $experience;

        $this->env['UI_AI_KIT_LANDING_ENABLED'] = $experience === 'landing' ? 'true' : 'false';
        $this->env['UI_AI_KIT_LANDING_ROUTE'] = $experience === 'landing' ? '/' : 'ui-ai-kit';
        $this->env['UI_AI_KIT_CHAT_PAGE_ENABLED'] = $experience === 'chat' ? 'true' : 'false';
        $this->env['UI_AI_KIT_CHAT_PAGE_ROUTE'] = $experience === 'chat' ? '/' : 'ui-ai-kit/assistant';
        $this->env['UI_AI_KIT_CONSOLE_ENABLED'] = 'false';
    }

    /**
     * Publish a ChatDriver stub into app/UiAiKit/{class}.php so the developer
     * only has to fill in the actual provider call, then register it once
     * with ChatManager::extend() (a reminder is printed after the wizard).
     */
    protected function generateDriverStub(string $class): void
    {
        $class = str_replace(['.php', '/'], '', $class);
        $directory = app_path('UiAiKit');
        $path = $directory.DIRECTORY_SEPARATOR.$class.'.php';

        if (is_file($path) && ! $this->option('force')) {
            $this->components->warn("app/UiAiKit/{$class}.php already exists — skipping (use --force to overwrite).");
            $this->customDriverClass = $class;

            return;
        }

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $stub = (string) file_get_contents(__DIR__.'/../../stubs/chat-driver.stub');
        $stub = str_replace(['{{ namespace }}', '{{ class }}'], ['App\\UiAiKit', $class], $stub);

        file_put_contents($path, $stub);

        $this->customDriverClass = $class;
        $this->components->task("Driver stub created at app/UiAiKit/{$class}.php");
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
