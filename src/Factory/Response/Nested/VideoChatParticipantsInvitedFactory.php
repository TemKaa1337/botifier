<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\VideoChatParticipantsInvited;
use Temkaa\Botifier\Model\Shared\User;

final readonly class VideoChatParticipantsInvitedFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): VideoChatParticipantsInvited
    {
        return new VideoChatParticipantsInvited(
            array_map(fn (array $nested): User => $this->userFactory->create($nested), $message['users'])
        );
    }
}
