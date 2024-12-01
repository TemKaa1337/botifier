<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\ChatBoostSourceGiftCode;

final readonly class ChatBoostSourceGiftCodeFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): ChatBoostSourceGiftCode
    {
        return new ChatBoostSourceGiftCode(
            $message['source'],
            $this->userFactory->create($message['user'])
        );
    }
}
