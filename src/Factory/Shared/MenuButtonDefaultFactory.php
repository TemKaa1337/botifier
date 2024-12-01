<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\MenuButtonDefault;

final readonly class MenuButtonDefaultFactory
{
    public function create(array $message): MenuButtonDefault
    {
        return new MenuButtonDefault(
            $message['type']
        );
    }
}
