<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ChatBoostAdded;

final readonly class ChatBoostAddedFactory
{
    public function create(array $message): ChatBoostAdded
    {
        return new ChatBoostAdded(
            $message['boost_count']
        );
    }
}
