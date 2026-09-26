<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class ChatbotComponentTest extends TestCase
{
    public function test_the_component_renders_with_configuration_defaults(): void
    {
        $this->blade('<x-ui-ai-kit::chatbot />')
            ->assertSee('AI Assistant')
            ->assertSee(config('ui-ai-kit.chatbot.welcome_message'))
            ->assertSee('data-position="bottom-right"', false);
    }

    public function test_attributes_override_configuration(): void
    {
        $this->blade('<x-ui-ai-kit::chatbot name="Support" position="bottom-left" />')
            ->assertSee('Support')
            ->assertSee('data-position="bottom-left"', false);
    }

    public function test_it_renders_nothing_when_disabled(): void
    {
        config()->set('ui-ai-kit.chatbot.enabled', false);

        $this->blade('<x-ui-ai-kit::chatbot />')->assertDontSee('uiaikit-chat__launcher');
    }

    public function test_messages_are_escaped(): void
    {
        config()->set('ui-ai-kit.chatbot.welcome_message', '<script>alert(1)</script>');

        $this->blade('<x-ui-ai-kit::chatbot />')->assertDontSee('<script>alert(1)</script>', false);
    }
}
