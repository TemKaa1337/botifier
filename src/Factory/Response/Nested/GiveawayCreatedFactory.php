<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\GiveawayCreated;

final readonly class GiveawayCreatedFactory
{
    public function create(array $message): GiveawayCreated
    {
        return new GiveawayCreated(
            $message['prize_star_count'] ?? null
        );
    }
}
