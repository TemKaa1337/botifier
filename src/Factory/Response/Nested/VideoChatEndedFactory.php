<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\VideoChatEnded;

final readonly class VideoChatEndedFactory
{
    public function create(array $message): VideoChatEnded
    {
        return new VideoChatEnded(
            $message['duration']
        );
    }
}
