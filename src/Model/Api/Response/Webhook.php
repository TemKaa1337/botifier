<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Api\Response;

use DateTimeImmutable;
use Temkaa\Botifier\Model\Shared\ResultInterface;

final readonly class Webhook implements ResultInterface
{
    public function __construct(
        private string $url,
        private bool $hasCustomCertificate,
        private int $pendingUpdatesCount,
        private ?string $ip,
        private ?DateTimeImmutable $lastErrorDateTime,
        private ?string $lastErrorMessage,
        private ?int $maxConnections,
        private ?array $allowedUpdates,
    ) {
    }

    public function getAllowedUpdates(): ?array
    {
        return $this->allowedUpdates;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getLastErrorDateTime(): ?DateTimeImmutable
    {
        return $this->lastErrorDateTime;
    }

    public function getLastErrorMessage(): ?string
    {
        return $this->lastErrorMessage;
    }

    public function getMaxConnections(): ?int
    {
        return $this->maxConnections;
    }

    public function getPendingUpdatesCount(): int
    {
        return $this->pendingUpdatesCount;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function hasCustomCertificate(): bool
    {
        return $this->hasCustomCertificate;
    }
}
