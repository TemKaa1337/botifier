<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatJoinRequest;

final readonly class ChatJoinRequestFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private UserFactory $userFactory,
        private ChatInviteLinkFactory $chatInviteLinkFactory
    ) {}

    public function create(array $message): ChatJoinRequest
    {
        return new ChatJoinRequest(
            $this->chatFactory->create($message['chat']),
            $this->userFactory->create($message['from']),
            $message['user_chat_id'],
            (new DateTimeImmutable())->setTimestamp($message['date'])->setTimezone(new DateTimeZone('UTC')),
            $message['bio'] ?? null,
            isset($message['invite_link']) ? $this->chatInviteLinkFactory->create($message['invite_link']) : null
        );
    }
}
