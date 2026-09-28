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
            ->assertSee(config('ui-ai-kit.chatbot.subtitle'))
            ->assertSee('data-open-label="Open AI Assistant"', false)
            ->assertSee('data-close-label="Close AI Assistant"', false)
            ->assertSee('data-position="bottom-right"', false);
    }

    public function test_attributes_override_configuration(): void
    {
        $this->blade('<x-ui-ai-kit::chatbot name="Support" subtitle="Speak to support" placeholder="Ask a question" position="bottom-left" />')
            ->assertSee('Support')
            ->assertSee('Speak to support')
            ->assertSee('placeholder="Ask a question"', false)
            ->assertSee('data-position="bottom-left"', false);
    }

    public function test_chatbot_copy_and_layout_are_configurable(): void
    {
        config()->set('ui-ai-kit.chatbot.subtitle', 'Talk with our team');
        config()->set('ui-ai-kit.chatbot.welcome_message', '');
        config()->set('ui-ai-kit.chatbot.empty_message', 'Choose a prompt or ask us anything.');
        config()->set('ui-ai-kit.chatbot.open_label', 'Start :name');
        config()->set('ui-ai-kit.chatbot.send_label', 'Send to support');
        config()->set('ui-ai-kit.chatbot.layout.width', '420px');
        config()->set('ui-ai-kit.theme.mode', 'light');

        $this->blade('<x-ui-ai-kit::chatbot name="Support" />')
            ->assertSee('Talk with our team')
            ->assertSee('Choose a prompt or ask us anything.')
            ->assertSee('aria-label="Start Support"', false)
            ->assertSee('aria-label="Send to support"', false)
            ->assertSee('--uiaikit-chat-width:420px', false)
            ->assertSee('data-uiaikit-theme="light"', false);
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
