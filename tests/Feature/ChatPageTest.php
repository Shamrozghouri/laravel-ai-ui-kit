<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class ChatPageTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('ui-ai-kit.landing.enabled', false);
        $app['config']->set('ui-ai-kit.console.enabled', false);
        $app['config']->set('ui-ai-kit.chat_page.enabled', true);
        $app['config']->set('ui-ai-kit.chat_page.route', '/');
        $app->booted(function (): void {
            Route::get('/', fn () => response('Starter home route'));
        });
    }

    public function test_the_chat_page_can_be_the_application_home_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-chat-app', false)
            ->assertSee('How can Laravel help you?')
            ->assertSee('About the creator')
            ->assertSee('Who is Shamroz Ghouri, and what does he build?')
            ->assertSee('Laravel Agent Evals')
            ->assertSee('What does Laravel Agent Evals do?')
            ->assertSee('Install the package')
            ->assertSee('composer require shamrozghouri/laravel-ui-ai-kit')
            ->assertSee('Choose my home page')
            ->assertSee('Customize the landing page')
            ->assertSee('Customize the chatbot UI')
            ->assertSee('Connect my AI provider')
            ->assertSee('Publish views and assets')
            ->assertSee('https://laravel.com/img/logomark.min.svg', false)
            ->assertSee('data-assistant-mark="https://laravel.com/img/logomark.min.svg"', false)
            ->assertSee('uiaikit-chat-brand__mark--image', false)
            ->assertSee('data-composer', false)
            ->assertSee('chat-page.js');

        $this->assertSame('/', Route::getRoutes()->getByName('ui-ai-kit.chat-page')->uri());
        $this->get('/ui-ai-kit')->assertNotFound();
    }

    public function test_chat_page_prompts_are_configurable(): void
    {
        config()->set('ui-ai-kit.chat_page.suggestions', [
            ['title' => 'Explain Eloquent', 'prompt' => 'Explain an Eloquent relationship.'],
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Explain Eloquent')
            ->assertSee('Explain an Eloquent relationship.');
    }

    public function test_the_starter_prompts_cover_the_package_setup_and_customization_topics(): void
    {
        $suggestions = config('ui-ai-kit.chat_page.suggestions');

        $this->assertCount(11, $suggestions);
        $this->assertStringContainsString('Shamroz Ghouri', $suggestions[0]['answer']);
        $this->assertStringContainsString('catches regressions', $suggestions[1]['answer']);
        $this->assertStringContainsString('composer require', $suggestions[2]['prompt']);
        $this->assertStringContainsString('browser-local conversation history', $suggestions[9]['prompt']);
        $this->assertStringContainsString('destination paths', $suggestions[10]['prompt']);
        $this->assertStringContainsString('UI_AI_KIT_CHAT_DRIVER=forward', $suggestions[8]['answer']);
        $this->assertStringContainsString('message`, `conversation_id`, and `history`', $suggestions[8]['answer']);
    }

    public function test_starter_prompts_have_local_echo_driver_answers(): void
    {
        $suggestions = config('ui-ai-kit.chat_page.suggestions');

        $this->get('/')
            ->assertOk()
            ->assertSee('data-driver="echo"', false)
            ->assertSee('data-answer=', false)
            ->assertSee('composer require shamrozghouri/laravel-ui-ai-kit');

        $this->assertStringContainsString('local demo', $suggestions[8]['answer']);
    }

    public function test_chat_page_assets_include_the_response_skeleton(): void
    {
        $this->get('/ui-ai-kit/assets/chat-page.js')
            ->assertOk()
            ->assertSee('uiaikit-chat-skeleton', false)
            ->assertSee('is thinking', false);

        $this->get('/ui-ai-kit/assets/chat.css')
            ->assertOk()
            ->assertSee('.uiaikit-chat-skeleton__line', false)
            ->assertSee('@keyframes uiaikit-chat-skeleton-shimmer', false)
            ->assertSee('prefers-reduced-motion: reduce', false);
    }

    public function test_text_chatbot_avatar_uses_a_text_mark_not_a_broken_image(): void
    {
        config()->set('ui-ai-kit.chatbot.avatar', 'AI');

        $this->get('/')
            ->assertOk()
            ->assertSee('data-assistant-mark=""', false)
            ->assertSee('data-assistant-monogram="AI"', false)
            ->assertDontSee('src="AI"', false);
    }
}
