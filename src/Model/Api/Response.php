<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api;

final readonly class Response
{
    public function __construct(
        private bool $success,
        private ?string $description,
        private ?int $errorCode,
        private bool|null|ResultInterface $result,
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

    public function getResult(): bool|null|ResultInterface
    {
        return $this->result;
    }

    public function success(): bool
    {
        return $this->success;
    }
}
