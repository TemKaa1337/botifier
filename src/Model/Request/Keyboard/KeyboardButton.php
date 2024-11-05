<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

// TODO: add test on this
final readonly class KeyboardButton
{
    use NullableArrayFilterTrait;

    public function __construct(
        private string $text,
        private ?KeyboardButtonRequestUsers $requestUsers = null,
        private ?KeyboardButtonRequestChat $requestChat = null,
        private ?bool $requestContact = null,
        private ?bool $requestLocation = null,
        private ?KeyboardButtonPollType $requestPoll = null,
        private ?WebApp $webApp = null,
    ) {
    }

    public function format(): array
    {
        return $this->filter(
            [
                'text'             => $this->text,
                'request_users'    => $this->requestUsers?->format() ?: null,
                'request_chat'     => $this->requestChat?->format() ?: null,
                'request_contact'  => $this->requestContact,
                'request_location' => $this->requestLocation,
                'request_poll'     => $this->requestPoll?->format() ?: null,
                'web_app'          => $this->webApp?->format() ?: null,
            ],
        );
    }
}
