<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: add test on this
final readonly class KeyboardButtonPollType
{
    public function __construct(
        private ?string $type = null,
    ) {
    }

    public function format(): array
    {
        return ['type' => $this->type];
    }
}
