<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use DateTimeImmutable;
use JsonException;
use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Shared\Message\Reply;

final readonly class ReplyFactory
{
    public function __construct(
        private MessageFactory $messageFactory,
        private ChatFactory $chatFactory,
        private UserFactory $userFactory,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function create(array $message): Reply
    {
        $nestedMessage = json_decode($message['text'], true, 512, JSON_THROW_ON_ERROR);

        $createdAt = (new DateTimeImmutable())->setTimestamp($message['created_at']);

        return new Reply(
            $message['message_id'],
            $this->chatFactory->create($message),
            $this->messageFactory->create($nestedMessage),
            $this->userFactory->create($message),
            $createdAt,
        );
    }
}
