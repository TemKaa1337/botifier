<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\GiveawayWinners;
use Temkaa\Botifier\Model\Shared\User;

final readonly class GiveawayWinnersFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private UserFactory $userFactory
    ) {}

    public function create(array $message): GiveawayWinners
    {
        return new GiveawayWinners(
            $this->chatFactory->create($message['chat']),
            $message['giveaway_message_id'],
            (new DateTimeImmutable())->setTimestamp($message['winners_selection_date'])->setTimezone(new DateTimeZone('UTC')),
            $message['winner_count'],
            array_map(fn (array $nested): User => $this->userFactory->create($nested), $message['winners']),
            $message['additional_chat_count'] ?? null,
            $message['prize_star_count'] ?? null,
            $message['premium_subscription_month_count'] ?? null,
            $message['unclaimed_prize_count'] ?? null,
            $message['only_new_members'] ?? null,
            $message['was_refunded'] ?? null,
            $message['prize_description'] ?? null
        );
    }
}
