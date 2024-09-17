<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Output\Keyboard;

final readonly class InlineKeyboardButton
{
    public function __construct(
        private string $text,
        private ?string $url = null,
        private ?string $callback = null,
    ) {
    }

    public function getCallback(): ?string
    {
        return $this->callback;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
