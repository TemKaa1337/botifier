<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BotDescription;

final readonly class BotDescriptionFactory
{
    public function create(array $message): BotDescription
    {
        return new BotDescription(
            $message['description']
        );
    }
}
