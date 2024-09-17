<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Webhook;

use Temkaa\Botifier\Model\Input\Message;
use Temkaa\Botifier\Serializer\Serializer;

final readonly class MessageProvider
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function provide(): Message
    {
        $message = file_get_contents('php://input');

        return current($this->serializer->deserialize($message));
    }
}
