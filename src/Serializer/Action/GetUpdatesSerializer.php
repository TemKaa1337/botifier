<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetUpdatesSerializer implements SerializerInterface
{
    public function __construct(
        private MessageSerializer $messageSerializer,
    ) {
    }

    public function deserialize(array $message): ResponseInterface
    {
        $result = $message['result'] ?? [];
        $result = match (true) {
            $result === []    => null,
            is_array($result) => $this->messageSerializer->deserialize($result),
            default           => $result,
        };

        return new GetUpdatesResponse(
            $message['ok'],
            $message['description'] ?? null,
            $message['error_code'] ?? null,
            $result,
            raw: $message
        );
    }

    public function supports(ApiMethod $action): bool
    {
        return $action === ApiMethod::GetUpdates;
    }
}
