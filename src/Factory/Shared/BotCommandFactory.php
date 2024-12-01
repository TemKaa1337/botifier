<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\BotCommand;

final readonly class BotCommandFactory
{
    public function create(array $message): BotCommand
    {
        return new BotCommand(
            $message['command'],
            $message['description']
        );
    }
}
