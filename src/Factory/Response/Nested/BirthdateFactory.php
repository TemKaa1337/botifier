<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Birthdate;

final readonly class BirthdateFactory
{
    public function create(array $message): Birthdate
    {
        return new Birthdate(
            $message['day'],
            $message['month'],
            $message['year'] ?? null
        );
    }
}
