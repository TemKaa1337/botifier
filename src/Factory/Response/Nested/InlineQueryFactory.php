<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\InlineQuery;

final readonly class InlineQueryFactory
{
    public function __construct(
        private UserFactory $userFactory,
        private LocationFactory $locationFactory
    ) {}

    public function create(array $message): InlineQuery
    {
        return new InlineQuery(
            $message['id'],
            $this->userFactory->create($message['from']),
            $message['query'],
            $message['offset'],
            $message['chat_type'] ?? null,
            isset($message['location']) ? $this->locationFactory->create($message['location']) : null
        );
    }
}
