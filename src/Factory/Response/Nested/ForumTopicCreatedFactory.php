<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ForumTopicCreated;

final readonly class ForumTopicCreatedFactory
{
    public function create(array $message): ForumTopicCreated
    {
        return new ForumTopicCreated(
            $message['name'],
            $message['icon_color'],
            $message['icon_custom_emoji_id'] ?? null
        );
    }
}
