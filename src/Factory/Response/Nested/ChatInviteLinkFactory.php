<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatInviteLink;

final readonly class ChatInviteLinkFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatInviteLink
    {
        return new ChatInviteLink(
            $message['invite_link'],
            $this->userFactory->create($message['creator']),
            $message['creates_join_request'],
            $message['is_primary'],
            $message['is_revoked'],
            $message['name'] ?? null,
            isset($message['expire_date']) ? (new DateTimeImmutable())->setTimestamp($message['expire_date'])->setTimezone(new DateTimeZone('UTC')) : null,
            $message['member_limit'] ?? null,
            $message['pending_join_request_count'] ?? null,
            $message['subscription_period'] ?? null,
            $message['subscription_price'] ?? null
        );
    }
}
