<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use DateTimeImmutable;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\ResultInterface;
use Temkaa\Botifier\Model\Response\Webhook;

/**
 * @internal
 */
final readonly class WebhookInfoSerializer implements SerializerInterface
{
    public function deserialize(array $message): ResultInterface
    {
        $lastErrorTimestamp = $message['last_error_date'] ?? null;
        $lastErrorDateTime = $lastErrorTimestamp
            ? (new DateTimeImmutable())->setTimestamp($lastErrorTimestamp)
            : null;

        return new Webhook(
            $message['url'],
            $message['has_custom_certificate'],
            $message['pending_update_count'],
            $message['ip_address'] ?? null,
            $lastErrorDateTime,
            $message['last_error_message'] ?? null,
            $message['max_connections'] ?? null,
            $message['allowed_updates'] ?? null,
        );
    }

    public function supports(ApiMethod $action): bool
    {
        return $action === ApiMethod::GetWebhookInfo;
    }
}
