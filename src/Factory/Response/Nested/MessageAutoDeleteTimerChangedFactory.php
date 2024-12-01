<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\MessageAutoDeleteTimerChanged;

final readonly class MessageAutoDeleteTimerChangedFactory
{
    public function create(array $message): MessageAutoDeleteTimerChanged
    {
        return new MessageAutoDeleteTimerChanged(
            $message['message_auto_delete_time']
        );
    }
}
