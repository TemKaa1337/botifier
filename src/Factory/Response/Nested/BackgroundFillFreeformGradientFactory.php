<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BackgroundFillFreeformGradient;

final readonly class BackgroundFillFreeformGradientFactory
{
    public function create(array $message): BackgroundFillFreeformGradient
    {
        return new BackgroundFillFreeformGradient(
            $message['type'],
            $message['colors']
        );
    }
}
