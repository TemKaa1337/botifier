<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Shared\Message\Chat;
use Temkaa\Botifier\Model\Shared\Message\ContentInterface;
use Temkaa\Botifier\Model\Shared\Message\Reply;
use Temkaa\Botifier\Model\Shared\Message\User;

final readonly class Message implements ResultInterface
{
    public function __construct(
        private int $id,
        private User $user,
        private Chat $chat,
        private ContentInterface $content,
        private int $updateId,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $editedAt = null,
        private bool $isEdit = false,
        private bool $isReply = false,
        private ?Reply $repliedTo = null,
    ) {
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getContent(): ContentInterface
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEditedAt(): ?DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRepliedTo(): ?Reply
    {
        return $this->repliedTo;
    }

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isEdit(): bool
    {
        return $this->isEdit;
    }

    public function isReply(): bool
    {
        return $this->isReply;
    }
}
