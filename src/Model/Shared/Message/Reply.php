<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared\Message;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Shared\Message;

final readonly class Reply
{
    public function __construct(
        private int $id,
        private Chat $chat,
        private Message $message,
        private User $user,
        private DateTimeImmutable $createdAt,
    ) {
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
