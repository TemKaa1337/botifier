<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use DateTimeImmutable;
use Exception;
use JsonException;
use Temkaa\Botifier\Factory\MessageFactory;
use Temkaa\Botifier\Model\Input\Message\Reply;

final class ReplyFactory
{
    public function __construct(
        private readonly MessageFactory $messageFactory,
        private readonly ChatFactory $chatFactory,
        private readonly UserFactory $userFactory,
    )
    {
    }

    /**
     * @throws Exception
     * @throws JsonException
     */
    public function create(array $message): Reply
    {
        $nestedMessage = json_decode($message['text'], true, 512, JSON_THROW_ON_ERROR);

        $createdAt = (new DateTimeImmutable())->setTimestamp($message['created_at']);

        return (new Reply())
            ->setId($message['message_id'])
            ->setMessage($this->messageFactory->create($nestedMessage))
            ->setCreatedAt($createdAt)
            ->setUser($this->userFactory->create($message))
            ->setChat($this->chatFactory->create($message));
    }
}
