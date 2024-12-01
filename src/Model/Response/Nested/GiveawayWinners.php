<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Shared\User;

final readonly class GiveawayWinners
{
    /**
     * @param User[] $winners
     */
    public function __construct(
        public Chat $chat,
        public int $giveawayMessageId,
        public DateTimeImmutable $winnersSelectionDate,
        public int $winnerCount,
        public array $winners,
        public ?int $additionalChatCount = null,
        public ?int $prizeStarCount = null,
        public ?int $premiumSubscriptionMonthCount = null,
        public ?int $unclaimedPrizeCount = null,
        public ?true $onlyNewMembers = null,
        public ?true $wasRefunded = null,
        public ?string $prizeDescription = null
    ) {}
}
