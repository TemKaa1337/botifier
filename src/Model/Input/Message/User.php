<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Input\Message;

use Temkaa\Botifier\Enum\Language;

final readonly class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $firstName,
        private bool $isBot,
        private Language $language,
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

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function isBot(): bool
    {
        return $this->isBot;
    }
}
