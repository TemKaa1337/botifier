<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

abstract readonly class AbstractResponse
{
    public function __construct(
        private bool $success,
        private ?string $description,
        private ?int $errorCode,
        private array $raw,
    ) {
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    public function raw(): array
    {
        return $this->raw;
    }

    public function success(): bool
    {
        return $this->success;
    }
}
