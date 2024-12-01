<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use Temkaa\Botifier\Trait\ArrayFilterTrait;

final readonly class ReplyKeyboardRemove
{
    use ArrayFilterTrait;

    public function __construct(
        public true $removeKeyboard,
        public ?bool $selective = null
    ) {}

    public function format(): array
    {
        return $this->filterNullable(
            [
                'remove_keyboard' => $this->removeKeyboard,
                'selective'       => $this->selective,
            ]
        );
    }
}
