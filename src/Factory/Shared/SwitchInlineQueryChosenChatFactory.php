<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\SwitchInlineQueryChosenChat;

final readonly class SwitchInlineQueryChosenChatFactory
{
    public function create(array $message): SwitchInlineQueryChosenChat
    {
        return new SwitchInlineQueryChosenChat(
            $message['query'] ?? null,
            $message['allow_user_chats'] ?? null,
            $message['allow_bot_chats'] ?? null,
            $message['allow_group_chats'] ?? null,
            $message['allow_channel_chats'] ?? null
        );
    }
}
