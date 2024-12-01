<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use Temkaa\Botifier\Trait\ArrayFilterTrait;

final readonly class KeyboardButtonPollType
{
    use ArrayFilterTrait;

    public function __construct(public ?string $type = null) {}

    public function format(): array
    {
        return $this->filterNullable(
            [
                'type' => $this->type,
            ]
        );
    }
}
