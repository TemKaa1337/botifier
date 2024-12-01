<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberOwner;

final readonly class ChatMemberOwnerFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatMemberOwner
    {
        return new ChatMemberOwner(
            $message['status'],
            $this->userFactory->create($message['user']),
            $message['is_anonymous'],
            $message['custom_title'] ?? null
        );
    }
}
