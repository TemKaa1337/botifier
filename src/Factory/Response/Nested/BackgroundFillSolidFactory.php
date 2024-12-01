<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BackgroundFillSolid;

final readonly class BackgroundFillSolidFactory
{
    public function create(array $message): BackgroundFillSolid
    {
        return new BackgroundFillSolid(
            $message['type'],
            $message['color']
        );
    }
}
