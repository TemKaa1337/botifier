<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: add test on this
final readonly class LoginUrl
{
    public function __construct(
        private string $url,
        private ?string $forwardText,
        private ?string $botUsername,
        private ?bool $requestWriteAccess,
    ) {
    }

    public function format(): array
    {
        return [
            'url' => $this->url,
            'forward_text' => $this->forwardText,
            'bot_username' => $this->botUsername,
            'request_write_access' => $this->requestWriteAccess,
        ];
    }
}
