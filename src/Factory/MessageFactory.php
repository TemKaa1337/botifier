<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use DateTimeImmutable;
use JsonException;
use Temkaa\Botifier\Factory\Message\ChatFactory;
use Temkaa\Botifier\Factory\Message\ContentFactory;
use Temkaa\Botifier\Factory\Message\ReplyFactory;
use Temkaa\Botifier\Factory\Message\UserFactory;
use Temkaa\Botifier\Model\Input\Message;

// TODO: move nested objects to separate factories
final readonly class MessageFactory
{
    public function __construct(
        private ChatFactory $chatFactory,
        private ContentFactory $contentFactory,
        private ReplyFactory $replyFactory,
        private UserFactory $userFactory,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function create(array $message): Message
    {
        $messageContent = $message['message'] ?? $message['edited_message'];

        $isReply = isset($messageContent['reply_to_message']);
        $isEdit = isset($message['edit_date']);

        $createdAt = (new DateTimeImmutable())->setTimestamp($message['created_at']);
        $editedAt = $isEdit
            ? (new DateTimeImmutable())->setTimestamp($message['edit_date'])
            : null;

        return new Message(
            $messageContent['message_id'],
            $this->userFactory->create($messageContent),
            $this->chatFactory->create($messageContent),
            $this->contentFactory->create($messageContent),
            $message['update_id'],
            $createdAt,
            $editedAt,
            $isEdit,
            $isReply,
            $this->replyFactory->create($messageContent['reply_to_message']),
        );
    }
}
