<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: add test on this
final readonly class SwitchInlineQueryChosenChat
{
    public function __construct(
        private ?string $query = null,
        private ?bool $allowUserChats = null,
        private ?bool $allowBotChats = null,
        private ?bool $allowGroupChats = null,
        private ?bool $allowChannelChats = null,
    ) {
    }

    public function format(): array
    {
        return [
            'query'               => $this->query,
            'allow_user_chats'    => $this->allowUserChats,
            'allow_bot_chats'     => $this->allowBotChats,
            'allow_group_chats'   => $this->allowGroupChats,
            'allow_channel_chats' => $this->allowChannelChats,
        ];
    }
}
