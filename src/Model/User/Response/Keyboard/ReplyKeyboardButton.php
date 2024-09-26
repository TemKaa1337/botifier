<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\User\Response\Keyboard;

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
