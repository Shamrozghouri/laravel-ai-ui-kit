<?php

namespace Shamrozghouri\LaravelUiAiKit;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Shamrozghouri\LaravelUiAiKit\Commands\InstallCommand;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\Services\ChatManager;
use Shamrozghouri\LaravelUiAiKit\View\Components\Chatbot;

class LaravelUiAiKitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ui-ai-kit.php', 'ui-ai-kit');

        $this->app->singleton(ChatManager::class);

        // Resolving ChatDriver gives you the configured driver. Rebind this in
        // your own provider to plug in a different AI backend.
        $this->app->bind(ChatDriver::class, fn ($app) => $app->make(ChatManager::class)->driver());
    }

    public function boot(): void
    {
        UiAiKit::flush();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ui-ai-kit');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->registerComponents();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->commands([InstallCommand::class]);
        }
    }

    protected function registerComponents(): void
    {
        // Keep the conventional <x-ui-ai-kit-chatbot> alias available.
        $this->loadViewComponentsAs('ui-ai-kit', [
            Chatbot::class,
        ]);

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade): void {
            $blade->component(Chatbot::class, 'ui-ai-kit::chatbot');

            // Package component namespaces use the <x-ui-ai-kit::...> syntax.
            // Register the class namespace before the anonymous views so the
            // chatbot entry point is hydrated by the Chatbot component class.
            $blade->componentNamespace(
                'Shamrozghouri\\LaravelUiAiKit\\View\\Components',
                'ui-ai-kit'
            );

            $blade->anonymousComponentPath(
                __DIR__.'/../resources/views/components',
                'ui-ai-kit'
            );
        });
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/ui-ai-kit.php' => config_path('ui-ai-kit.php'),
        ], 'ui-ai-kit-config');

        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vendor/ui-ai-kit/css'),
            __DIR__.'/../resources/js' => public_path('vendor/ui-ai-kit/js'),
            __DIR__.'/../resources/images' => public_path('vendor/ui-ai-kit/images'),
        ], 'ui-ai-kit-assets');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ui-ai-kit'),
        ], 'ui-ai-kit-views');

        $this->publishes([
            __DIR__.'/../resources/views/components/chatbot' => resource_path('views/vendor/ui-ai-kit/components/chatbot'),
            __DIR__.'/../resources/views/console' => resource_path('views/vendor/ui-ai-kit/console'),
            __DIR__.'/../resources/views/chat-page' => resource_path('views/vendor/ui-ai-kit/chat-page'),
        ], 'ui-ai-kit-chatbot-views');
    }
}
