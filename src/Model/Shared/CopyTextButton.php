<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

final readonly class CopyTextButton
{
    public function __construct(public string $text) {}

    public function format(): array
    {
        return [
            'text' => $this->text,
        ];
    }
}
