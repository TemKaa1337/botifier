<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberLeft;

final readonly class ChatMemberLeftFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatMemberLeft
    {
        return new ChatMemberLeft(
            $message['status'],
            $this->userFactory->create($message['user'])
        );
    }
}
