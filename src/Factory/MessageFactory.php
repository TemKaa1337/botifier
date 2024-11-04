<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use DateTimeImmutable;
use JsonException;
use Temkaa\Botifier\Factory\Message\ChatFactory;
use Temkaa\Botifier\Factory\Message\ContentFactory;
use Temkaa\Botifier\Factory\Message\UserFactory;
use Temkaa\Botifier\Model\Response\Message;

/**
 * @internal
 */
final readonly class MessageFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private ContentFactory $contentFactory,
        private UserFactory $userFactory,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function create(array $message): Message
    {
        $messageContent = $message['message'] ?? $message['edited_message'] ?? $message;

        $isReply = isset($messageContent['reply_to_message']);
        $isEdit = isset($messageContent['edit_date']);

        $createdAt = (new DateTimeImmutable())->setTimestamp($messageContent['date']);
        $editedAt = $isEdit
            ? (new DateTimeImmutable())->setTimestamp($messageContent['edit_date'])
            : null;

        return new Message(
            $messageContent['message_id'],
            $this->userFactory->create($messageContent),
            $this->chatFactory->create($messageContent),
            $this->contentFactory->create($messageContent),
            $message['update_id'] ?? null,
            $createdAt,
            $editedAt,
            $isEdit,
            $isReply,
            $isReply ? $this->create($messageContent['reply_to_message']) : null,
            json_encode($message, JSON_THROW_ON_ERROR),
        );
    }
}
