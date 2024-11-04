<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use JsonException;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Serializer\Action\MessageSerializer;

/**
 * @internal
 */
final readonly class MessageProvider
{
    public function __construct(
        private MessageSerializer $messageSerializer,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function provide(): Message
    {
        $message = file_get_contents('php://input');

        return $this->messageSerializer->deserialize(json_decode($message, true, 512, JSON_THROW_ON_ERROR));
    }
}
