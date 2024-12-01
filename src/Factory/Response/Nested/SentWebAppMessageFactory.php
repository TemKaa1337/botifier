<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\SentWebAppMessage;

final readonly class SentWebAppMessageFactory
{
    public function create(array $message): SentWebAppMessage
    {
        return new SentWebAppMessage(
            $message['inline_message_id'] ?? null
        );
    }
}
