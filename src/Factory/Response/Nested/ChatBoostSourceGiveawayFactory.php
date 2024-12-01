<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatBoostSourceGiveaway;

final readonly class ChatBoostSourceGiveawayFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatBoostSourceGiveaway
    {
        return new ChatBoostSourceGiveaway(
            $message['source'],
            $message['giveaway_message_id'],
            isset($message['user']) ? $this->userFactory->create($message['user']) : null,
            $message['prize_star_count'] ?? null,
            $message['is_unclaimed'] ?? null
        );
    }
}
