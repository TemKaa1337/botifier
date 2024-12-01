<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatMemberBanned;

final readonly class ChatMemberBannedFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatMemberBanned
    {
        return new ChatMemberBanned(
            $message['status'],
            $this->userFactory->create($message['user']),
            (new DateTimeImmutable())->setTimestamp($message['until_date'])->setTimezone(new DateTimeZone('UTC'))
        );
    }
}
