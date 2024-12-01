<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\BusinessMessagesDeleted;

final readonly class BusinessMessagesDeletedFactory
{
    public function __construct(private ChatFactory $chatFactory) {}

    public function create(array $message): BusinessMessagesDeleted
    {
        return new BusinessMessagesDeleted(
            $message['business_connection_id'],
            $this->chatFactory->create($message['chat']),
            $message['message_ids']
        );
    }
}
