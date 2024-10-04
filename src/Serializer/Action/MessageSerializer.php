<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use JsonException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Response\ResultInterface;

/**
 * @internal
 */
final readonly class MessageSerializer implements SerializerInterface
{
    public function __construct(
        private MessageFactory $messageFactory,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function deserialize(array $message): ResultInterface
    {
        return $this->messageFactory->create($message);
    }

    public function supports(ApiMethod $action): bool
    {
        return $action === ApiMethod::GetUpdates;
    }
}
