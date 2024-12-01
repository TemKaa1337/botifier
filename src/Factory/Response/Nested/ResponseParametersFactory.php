<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;

final readonly class ResponseParametersFactory
{
    public function create(array $message): ResponseParameters
    {
        return new ResponseParameters(
            $message['migrate_to_chat_id'] ?? null,
            $message['retry_after'] ?? null
        );
    }
}
