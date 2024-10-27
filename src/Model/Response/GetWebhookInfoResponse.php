<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use DateTimeImmutable;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetWebhookInfoResponse extends AbstractResponse implements ResponseInterface
{
    public function __construct(
        bool $success,
        ?string $description,
        ?int $errorCode,
        private ?string $url,
        private ?bool $hasCustomCertificate,
        private ?int $pendingUpdatesCount,
        private ?string $ip,
        private ?DateTimeImmutable $lastErrorDateTime,
        private ?string $lastErrorMessage,
        private ?int $maxConnections,
        private ?array $allowedUpdates,
        array $raw,
    ) {
        parent::__construct($success, $description, $errorCode, $raw);
    }

    public function getAllowedUpdates(): ?array
    {
        return $this->allowedUpdates;
    }

    public function getHasCustomCertificate(): ?bool
    {
        return $this->hasCustomCertificate;
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

    public function getPendingUpdatesCount(): ?int
    {
        return $this->pendingUpdatesCount;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
