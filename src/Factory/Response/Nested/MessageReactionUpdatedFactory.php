<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Temkaa\Botifier\Factory\Shared\ReactionTypeCustomEmojiFactory;
use Temkaa\Botifier\Factory\Shared\ReactionTypeEmojiFactory;
use Temkaa\Botifier\Factory\Shared\ReactionTypePaidFactory;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\MessageReactionUpdated;
use Temkaa\Botifier\Model\Shared\ReactionTypeCustomEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypeEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypePaid;

final readonly class MessageReactionUpdatedFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private ReactionTypeEmojiFactory $reactionTypeEmojiFactory,
        private ReactionTypeCustomEmojiFactory $reactionTypeCustomEmojiFactory,
        private ReactionTypePaidFactory $reactionTypePaidFactory,
        private UserFactory $userFactory
    ) {}

    public function create(array $message): MessageReactionUpdated
    {
        $factory = match (true) {
            is_array($message['old_reaction']) && $message[0]['type'] === 'emoji'        => $this->reactionTypeEmojiFactory,
            is_array($message['old_reaction']) && $message[0]['type'] === 'custom_emoji' => $this->reactionTypeCustomEmojiFactory,
            is_array($message['old_reaction']) && $message[0]['type'] === 'paid'         => $this->reactionTypePaidFactory,
            default                                                                      => null,
        };
        $factory = match (true) {
            is_array($message['new_reaction']) && $message[0]['type'] === 'emoji'        => $this->reactionTypeEmojiFactory,
            is_array($message['new_reaction']) && $message[0]['type'] === 'custom_emoji' => $this->reactionTypeCustomEmojiFactory,
            is_array($message['new_reaction']) && $message[0]['type'] === 'paid'         => $this->reactionTypePaidFactory,
            default                                                                      => null,
        };

        return new MessageReactionUpdated(
            $this->chatFactory->create($message['chat']),
            $message['message_id'],
            (new DateTimeImmutable())->setTimestamp($message['date'])->setTimezone(new DateTimeZone('UTC')),
            match (true) {
                $factory !== null => array_map(
                    static fn (array $nested): ReactionTypeEmoji|ReactionTypeCustomEmoji|ReactionTypePaid => $factory->create($nested),
                    $message['old_reaction']
                ),
                default           => throw new InvalidArgumentException(sprintf('Could not find factory for message in factory: "%s".', self::class))
            },
            match (true) {
                $factory !== null => array_map(
                    static fn (array $nested): ReactionTypeEmoji|ReactionTypeCustomEmoji|ReactionTypePaid => $factory->create($nested),
                    $message['new_reaction']
                ),
                default           => throw new InvalidArgumentException(sprintf('Could not find factory for message in factory: "%s".', self::class))
            },
            isset($message['user']) ? $this->userFactory->create($message['user']) : null,
            isset($message['actor_chat']) ? $this->chatFactory->create($message['actor_chat']) : null
        );
    }
}
