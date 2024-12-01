<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\ForumTopicEdited;

final readonly class ForumTopicEditedFactory
{
    public function create(array $message): ForumTopicEdited
    {
        return new ForumTopicEdited(
            $message['name'] ?? null,
            $message['icon_custom_emoji_id'] ?? null
        );
    }
}
