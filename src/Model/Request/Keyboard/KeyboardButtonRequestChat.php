<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

// TODO: add test on this
final readonly class KeyboardButtonRequestChat
{
    use NullableArrayFilterTrait;

    public function __construct(
        private int $requestId,
        private bool $chatIsChannel,
        private ?bool $chatIsForum = null,
        private ?bool $chatHasUsername = null,
        private ?bool $chatIsCreated = null,
        private ?ChatAdministratorRights $userAdministratorRights = null,
        private ?ChatAdministratorRights $botAdministratorRights = null,
        private ?bool $botIsMember = null,
        private ?bool $requestTitle = null,
        private ?bool $requestUsername = null,
        private ?bool $requestPhoto = null,
    ) {
    }

    public function format(): array
    {
        return $this->filter(
            [
                'request_id'                => $this->requestId,
                'chat_is_channel'           => $this->chatIsChannel,
                'chat_is_forum'             => $this->chatIsForum,
                'chat_has_username'         => $this->chatHasUsername,
                'chat_is_created'           => $this->chatIsCreated,
                'user_administrator_rights' => $this->userAdministratorRights?->format() ?: null,
                'bot_administrator_rights'  => $this->botAdministratorRights->format() ?: null,
                'bot_is_member'             => $this->botIsMember,
                'request_title'             => $this->requestTitle,
                'request_username'          => $this->requestUsername,
                'request_photo'             => $this->requestPhoto,
            ],
        );
    }
}
