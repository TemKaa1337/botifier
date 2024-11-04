<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\GeneralResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GeneralSerializer implements SerializerInterface
{
    private const array SUPPORTED_METHODS = [
        ApiMethod::DeleteDescription,
        ApiMethod::DeleteWebhook,
        ApiMethod::SetDescription,
        ApiMethod::SetWebhook,
    ];

    public function deserialize(array $message): ResponseInterface
    {
        return new GeneralResponse(
            $message['ok'],
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            $message['result'] ?? null,
            raw: $message,
        );
    }

    public function supports(ApiMethod $action): bool
    {
        return in_array($action, self::SUPPORTED_METHODS, true);
    }
}
