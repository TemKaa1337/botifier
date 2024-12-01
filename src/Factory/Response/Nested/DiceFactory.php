<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Dice;

final readonly class DiceFactory
{
    public function create(array $message): Dice
    {
        return new Dice(
            $message['emoji'],
            $message['value']
        );
    }
}
