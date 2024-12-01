<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\MenuButtonCommands;

final readonly class MenuButtonCommandsFactory
{
    public function create(array $message): MenuButtonCommands
    {
        return new MenuButtonCommands(
            $message['type']
        );
    }
}
