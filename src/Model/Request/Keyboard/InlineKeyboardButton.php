<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: add test on this
final readonly class InlineKeyboardButton
{
    public function __construct(
        private string $text,
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
