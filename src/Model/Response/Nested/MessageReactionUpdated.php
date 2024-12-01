<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Nested;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Shared\ReactionTypeCustomEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypeEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypePaid;
use Temkaa\Botifier\Model\Shared\User;

final readonly class MessageReactionUpdated
{
    /**
     * @param ReactionTypeEmoji[]|ReactionTypeCustomEmoji[]|ReactionTypePaid[] $oldReaction
     * @param ReactionTypeEmoji[]|ReactionTypeCustomEmoji[]|ReactionTypePaid[] $newReaction
     */
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public DateTimeImmutable $date,
        public array $oldReaction,
        public array $newReaction,
        public ?User $user = null,
        public ?Chat $actorChat = null
    ) {}
}
