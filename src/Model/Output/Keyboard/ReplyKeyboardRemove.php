<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Output\Keyboard;

final readonly class ReplyKeyboardRemove
{
    private true $remove;

    public function __construct(
        private bool $selective = false,
    ) {
        $this->remove = true;
    }

    public function getRemove(): true
    {
        return $this->remove;
    }

    public function isSelective(): bool
    {
        return $this->selective;
    }
}
