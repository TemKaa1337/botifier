<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer;

use JsonException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Exception\NotFoundException;
use Temkaa\Botifier\Model\ResponseInterface;
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
    public function deserialize(ApiMethod $action, string $message): ResponseInterface
    {
        $decoded = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        return $this->getHandler($action)->deserialize($decoded);
    }

    private function getHandler(ApiMethod $action): ActionSerializerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($action)) {
                return $handler;
            }
        }

        throw new NotFoundException(
            sprintf('Could not find suitable deserializer for "%s" api method.', $action->value),
        );
    }
}
