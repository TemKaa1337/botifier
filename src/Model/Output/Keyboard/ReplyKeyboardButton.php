<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Output\Keyboard;

final readonly class ReplyKeyboardButton
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
