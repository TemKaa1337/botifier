<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

use Temkaa\Botifier\Model\Shared\User;

final readonly class ChatBoostSourceGiveaway
{
    public function __construct(
        public string $source,
        public int $giveawayMessageId,
        public ?User $user = null,
        public ?int $prizeStarCount = null,
        public ?true $isUnclaimed = null
    ) {}
}
