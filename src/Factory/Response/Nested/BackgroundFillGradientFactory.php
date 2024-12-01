<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BackgroundFillGradient;

final readonly class BackgroundFillGradientFactory
{
    public function create(array $message): BackgroundFillGradient
    {
        return new BackgroundFillGradient(
            $message['type'],
            $message['top_color'],
            $message['bottom_color'],
            $message['rotation_angle']
        );
    }
}
