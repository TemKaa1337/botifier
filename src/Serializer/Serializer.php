<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use JsonException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\Response\Response;
use Temkaa\Botifier\Model\Response\ResultInterface;
use Temkaa\Botifier\Serializer\Action\SerializerInterface as ActionSerializerInterface;

/**
 * @internal
 */
final readonly class Serializer implements SerializerInterface
{
    /**
     * @param list<ActionSerializerInterface> $handlers
     */
    public function __construct(
        private array $handlers,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function deserialize(ApiMethod $action, string $message): Response
    {
        $decoded = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        return new Response(
            $decoded['ok'],
            $decoded['description'] ?? null,
            $decoded['error_code'] ?? null,
            $this->getResult($decoded, $action),
            raw: $message,
        );
    }

    private function getHandler(ApiMethod $action): ActionSerializerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($action)) {
                return $handler;
            }
        }
        // TODO: if not found throw an exception
        // TODO: change ?logger to NullableLogger
    }

    private function getResult(array $decoded, ApiMethod $action): array|bool|null|ResultInterface
    {
        $result = $decoded['result'] ?? null;
        if (!$result || is_bool($result)) {
            return $result;
        }

        $handler = $this->getHandler($action);
        if (is_array($result) && array_is_list($result)) {

            return array_map(
                static fn (array $entry): ResultInterface => $handler->deserialize($entry),
                $result,
            );
        }

        return $handler->deserialize($result);
    }
}
