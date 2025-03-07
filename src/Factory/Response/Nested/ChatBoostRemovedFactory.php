<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Temkaa\Botifier\Model\Response\Nested\ChatBoostRemoved;

final readonly class ChatBoostRemovedFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private ChatBoostSourcePremiumFactory $chatBoostSourcePremiumFactory,
        private ChatBoostSourceGiftCodeFactory $chatBoostSourceGiftCodeFactory,
        private ChatBoostSourceGiveawayFactory $chatBoostSourceGiveawayFactory
    ) {}

    public function create(array $message): ChatBoostRemoved
    {
        return new ChatBoostRemoved(
            $this->chatFactory->create($message['chat']),
            $message['boost_id'],
            (new DateTimeImmutable())->setTimestamp($message['remove_date'])->setTimezone(new DateTimeZone('UTC')),
            match (true) {
                $message['source']['source'] === 'premium'   => $this->chatBoostSourcePremiumFactory->create($message['source']),
                $message['source']['source'] === 'gift_code' => $this->chatBoostSourceGiftCodeFactory->create($message['source']),
                $message['source']['source'] === 'giveaway'  => $this->chatBoostSourceGiveawayFactory->create($message['source']),
                default                                      => throw new InvalidArgumentException('Could not find factory for message.')
            }
        );
    }
}
