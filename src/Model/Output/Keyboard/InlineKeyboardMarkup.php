<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Output\Keyboard;

final readonly class InlineKeyboardMarkup
{
    /**
     * @param list<list<InlineKeyboardButton>> $buttons
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
