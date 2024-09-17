<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Input\Message\Chat;

final readonly class ChatFactory
{
    public function create(array $message): Chat
    {
        $chat = $message['chat'];

        return new Chat(
            $chat['id'],
            $chat['username'],
            $chat['first_name'],
            $chat['type'],
        );
    }
}
