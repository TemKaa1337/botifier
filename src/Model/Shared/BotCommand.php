<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

final readonly class BotCommand
{
    public function __construct(
        public string $command,
        public string $description
    ) {}

    public function format(): array
    {
        return [
            'command'     => $this->command,
            'description' => $this->description,
        ];
    }
}
