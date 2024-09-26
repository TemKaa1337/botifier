<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\User\Response\Keyboard;

final readonly class ReplyKeyboardMarkup
{
    /**
     * @param ReplyKeyboardButton $buttons
     */
    public function __construct(
        private array $buttons,
        private bool $persistent = false,
        private bool $resize = false,
        private bool $shouldBeUsedOnce = false,
        private ?string $placeholder = null,
        private bool $selective = false,
    ) {
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function isPersistent(): bool
    {
        return $this->persistent;
    }

    public function isResize(): bool
    {
        return $this->resize;
    }

    public function isSelective(): bool
    {
        return $this->selective;
    }

    public function isShouldBeUsedOnce(): bool
    {
        return $this->shouldBeUsedOnce;
    }
}
