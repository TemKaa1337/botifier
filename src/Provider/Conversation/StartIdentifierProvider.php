<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Conversation;

use Temkaa\Botifier\Model\CurrentConversation\Identifier;
use Temkaa\Botifier\Model\Response\Nested\Update;

final readonly class StartIdentifierProvider implements StartIdentifierProviderInterface
{
    public function provide(Update $update): ?Identifier
    {
        if ($update->message === null || $update->message->from === null) {
            return null;
        }

        return new Identifier($update->message->chat->id, $update->message->from->id);
    }
}
