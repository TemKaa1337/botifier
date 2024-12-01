<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChosenInlineResult;

final readonly class ChosenInlineResultFactory
{
    public function __construct(
        private UserFactory $userFactory,
        private LocationFactory $locationFactory
    ) {}

    public function create(array $message): ChosenInlineResult
    {
        return new ChosenInlineResult(
            $message['result_id'],
            $this->userFactory->create($message['from']),
            $message['query'],
            isset($message['location']) ? $this->locationFactory->create($message['location']) : null,
            $message['inline_message_id'] ?? null
        );
    }
}
