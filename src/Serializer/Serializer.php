<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use JsonException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response;
use Temkaa\Botifier\Model\Api\ResultInterface;
use Temkaa\Botifier\Serializer\Action\SerializerInterface as ActionSerializerInterface;
use Temkaa\SimpleContainer\Attribute\Bind\InstanceOfIterator;

final readonly class Serializer implements SerializerInterface
{
    /**
     * @param list<ActionSerializerInterface> $handlers
     */
    public function __construct(
        #[InstanceOfIterator(ActionSerializerInterface::class)]
        private array $handlers,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function deserialize(Action $action, string $message): Response
    {
        $decoded = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        return new Response(
            $decoded['ok'],
            $decoded['description'] ?? null,
            $decoded['error_code'] ?? null,
            $this->getResult($decoded, $action),
        );
    }

    private function getHandler(Action $action): ActionSerializerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($action)) {
                return $handler;
            }
        }
        // TODO: if not found throw an exception
    }

    private function getResult(array $decoded, Action $action): bool|null|ResultInterface
    {
        $result = $decoded['result'] ?? null;
        if (!$result || is_bool($result)) {
            return $result;
        }

        return $this->getHandler($action)->deserialize($result);
    }
}
