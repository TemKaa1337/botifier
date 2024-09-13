<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use DateTimeImmutable;
use Exception;
use Temkaa\Botifier\Factory\Message\ChatFactory;
use Temkaa\Botifier\Factory\Message\ContentFactory;
use Temkaa\Botifier\Factory\Message\ReplyFactory;
use Temkaa\Botifier\Factory\Message\UserFactory;
use Temkaa\Botifier\Model\Input\Message;

// TODO: move nested objects to separate factories
final class MessageFactory
{
    public function __construct(
        private readonly ChatFactory $chatFactory,
        private readonly ContentFactory $contentFactory,
        private readonly ReplyFactory $replyFactory,
        private readonly UserFactory $userFactory,
    ) {
    }

    /**
     * @throws Exception
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

        return (new Message())
            ->setChat($this->chatFactory->create($messageContent))
            ->setUser($this->userFactory->create($messageContent))
            ->setUpdateId($message['update_id'])
            ->setId($messageContent['message_id'])
            ->setCreatedAt($createdAt)
            ->setEditedAt($editedAt)
            ->setIsEdit($isEdit)
            ->setIsReply($isReply)
            ->setRepliedTo($this->replyFactory->create($messageContent['reply_to_message']))
            ->setContent($this->contentFactory->create($messageContent));
    }
}
