<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Serializer\Action;

use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Response\Message;

final readonly class MessageSerializer
{
    public function __construct(
        private MessageFactory $messageFactory,
    ) {
    }

    public function deserialize(array $message): array|Message
    {
        return array_is_list($message)
            ? array_map(
                fn (array $nestedMessage): Message => $this->messageFactory->create($nestedMessage),
                $message,
            )
            : $this->messageFactory->create($message);
    }
}
