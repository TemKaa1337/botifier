<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ChatBoost;
use Temkaa\Botifier\Model\Response\Nested\UserChatBoosts;

final readonly class UserChatBoostsFactory
{
    public function __construct(private ChatBoostFactory $chatBoostFactory) {}

    public function create(array $message): UserChatBoosts
    {
        return new UserChatBoosts(
            array_map(fn (array $nested): ChatBoost => $this->chatBoostFactory->create($nested), $message['boosts'])
        );
    }
}
