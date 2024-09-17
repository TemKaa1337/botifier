<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Input\Message;

final readonly class Chat
{
    public function __construct(
        private int $id,
        private string $username,
        private string $firstName,
        private string $type,
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
