<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\User\Response\Keyboard;

final readonly class InlineKeyboardMarkup
{
    /**
     * @param InlineKeyboardButton $buttons
     */
    public function __construct(
        private array $buttons,
    ) {
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }
}
