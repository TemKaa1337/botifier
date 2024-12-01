<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Shared;

use Temkaa\Botifier\Model\Shared\MaskPosition;

final readonly class MaskPositionFactory
{
    public function create(array $message): MaskPosition
    {
        return new MaskPosition(
            $message['point'],
            $message['x_shift'],
            $message['y_shift'],
            $message['scale']
        );
    }
}
