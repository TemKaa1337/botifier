<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Response\Message\Chat;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;
use Temkaa\Botifier\Model\Response\Message\User;

/**
 * @api
 */
final readonly class Message implements ResultInterface
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        private int $id,
        private User $user,
        private Chat $chat,
        private ContentInterface $content,
        /** @description can be null because inner message does not have updateId */
        private ?int $updateId,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $editedAt,
        private bool $isEdit,
        private bool $isReply,
        private ?self $repliedTo,
        private string $raw,
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

    public function getRaw(): string
    {
        return $this->raw;
    }

    public function getRepliedTo(): ?Message
    {
        return $this->repliedTo;
    }

    public function getUpdateId(): ?int
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
