<?php

namespace Shamrozghouri\LaravelUiAiKit\Services;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Client\Factory as HttpFactory;
use InvalidArgumentException;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\EchoDriver;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\ForwardDriver;

class ChatManager
{
    /** @var array<string, Closure(Container): ChatDriver> */
    protected array $custom = [];

    public function __construct(protected Container $app) {}

    /**
     * Register an additional driver.
     *
     * @param  Closure(Container): ChatDriver  $resolver
     */
    public function extend(string $name, Closure $resolver): void
    {
        $this->custom[$name] = $resolver;
    }

    public function driver(?string $name = null): ChatDriver
    {
        $name ??= $this->app['config']->get('ui-ai-kit.api.driver', 'echo');

        if (isset($this->custom[$name])) {
            return ($this->custom[$name])($this->app);
        }

        return match ($name) {
            'echo' => new EchoDriver,
            'forward' => new ForwardDriver(
                $this->app->make(HttpFactory::class),
                $this->app['config']->get('ui-ai-kit.api.endpoint'),
                (int) $this->app['config']->get('ui-ai-kit.api.timeout', 30),
                (array) $this->app['config']->get('ui-ai-kit.api.headers', []),
            ),
            default => throw new InvalidArgumentException("Chat driver [{$name}] is not registered."),
        };
    }
}
