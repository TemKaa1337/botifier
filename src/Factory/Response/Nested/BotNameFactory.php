<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BotName;

final readonly class BotNameFactory
{
    public function create(array $message): BotName
    {
        return new BotName(
            $message['name']
        );
    }
}
