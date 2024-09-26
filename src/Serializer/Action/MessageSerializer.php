<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Shared\ResultInterface;

final readonly class MessageSerializer implements SerializerInterface
{
    public function __construct(
        private MessageFactory $messageFactory,
    ) {
    }

    public function deserialize(array $message): ResultInterface
    {
        return $this->messageFactory->create($message);
    }

    public function supports(Action $action): bool
    {
        return $action === Action::GetUpdates;
    }
}
