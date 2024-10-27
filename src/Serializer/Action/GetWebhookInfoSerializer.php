<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use DateTimeImmutable;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\GetWebhookInfoResponse;
use Temkaa\Botifier\Model\ResponseInterface;

/**
 * @internal
 */
final readonly class GetWebhookInfoSerializer implements SerializerInterface
{
    public function deserialize(array $message): ResponseInterface
    {
        $result = $message['result'] ?? [];
        $lastErrorTimestamp = $result['last_error_date'] ?? null;
        $lastErrorDateTime = $lastErrorTimestamp
            ? (new DateTimeImmutable())->setTimestamp($lastErrorTimestamp)
            : null;

        return new GetWebhookInfoResponse(
            $message['ok'],
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            $result['url'] ?? null,
            $result['has_custom_certificate'] ?? null,
            $result['pending_update_count'] ?? null,
            $result['ip_address'] ?? null,
            $lastErrorDateTime,
            $result['last_error_message'] ?? null,
            $result['max_connections'] ?? null,
            $result['allowed_updates'] ?? null,
            raw: $message
        );
    }

    public function supports(ApiMethod $action): bool
    {
        return $action === ApiMethod::GetWebhookInfo;
    }
}
