<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberMember;

final readonly class ChatMemberMemberFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatMemberMember
    {
        return new ChatMemberMember(
            $message['status'],
            $this->userFactory->create($message['user']),
            isset($message['until_date']) ? (new DateTimeImmutable())->setTimestamp($message['until_date'])->setTimezone(new DateTimeZone('UTC')) : null
        );
    }
}
