<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Input\Message\Chat;

final class ChatFactory
{
    public function create(array $message): Chat
    {
        $chat = $message['chat'];

        return (new Chat())
            ->setFirstName($chat['first_name'])
            ->setId($chat['id'])
            ->setType($chat['type'])
            ->setUsername($chat['username']);
    }
}
