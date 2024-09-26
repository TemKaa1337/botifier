<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api\Response;

use Temkaa\Botifier\Model\Shared\ResultInterface;

final readonly class BaseResponse
{
    public function __construct(
        private bool $success,
        private ?string $description,
        private ?int $errorCode,
        private array|bool|null|ResultInterface $result,
        private string $raw,
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

    public function getResult(): array|bool|null|ResultInterface
    {
        return $this->result;
    }

    public function raw(): string
    {
        return $this->raw;
    }

    public function success(): bool
    {
        return $this->success;
    }
}
