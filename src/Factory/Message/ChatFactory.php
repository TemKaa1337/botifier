<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message;

use Temkaa\Botifier\Model\Response\Message\Chat;

/**
 * @internal
 */
final readonly class ChatFactory
{
    /**
     * @param array{
     *     chat: array {
     *         id: int,
     *         username: string,
     *         first_name: string,
     *         type: string
     *     }
     * } $message
     */
    public function create(array $message): Chat
    {
        $chat = $message['chat'];

        return new Chat($chat['id'], $chat['username'], $chat['first_name'], $chat['type']);
    }
}
