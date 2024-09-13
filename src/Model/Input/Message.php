<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Input;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Input\Message\Chat;
use Temkaa\Botifier\Model\Input\Message\Reply;
use Temkaa\Botifier\Model\Input\Message\User;

final class Message
{
    private Chat $chat;

    private ContentInterface $content;

    private DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $editedAt = null;

    private int $id;

    private bool $isEdit = false;

    private bool $isReply = false;

    private ?Reply $repliedTo = null;

    private int $updateId;

    private User $user;

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    public function getContent(): ContentInterface
    {
        return $this->content;
    }

    public function setContent(ContentInterface $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEditedAt(): ?DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(?DateTimeImmutable $editedAt): self
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getRepliedTo(): ?Reply
    {
        return $this->repliedTo;
    }

    public function setRepliedTo(?Reply $repliedTo): self
    {
        $this->repliedTo = $repliedTo;

        return $this;
    }

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function setUpdateId(int $updateId): self
    {
        $this->updateId = $updateId;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isEdit(): bool
    {
        return $this->isEdit;
    }

    public function setIsEdit(bool $isEdit): self
    {
        $this->isEdit = $isEdit;

        return $this;
    }

    public function isReply(): bool
    {
        return $this->isReply;
    }

    public function setIsReply(bool $isReply): self
    {
        $this->isReply = $isReply;

        return $this;
    }
}
