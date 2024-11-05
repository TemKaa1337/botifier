<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

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
