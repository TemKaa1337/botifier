<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Conversation;

use Temkaa\Botifier\Model\CurrentConversation\Identifier;
use Temkaa\Botifier\Model\Response\Nested\Update;

final readonly class SearchIdentifierProvider implements SearchIdentifierProviderInterface
{
    public function provide(Update $update): ?Identifier
    {
        if ($update->callbackQuery?->message === null) {
            return null;
        }

        return new Identifier($update->callbackQuery->message->chat->id, $update->callbackQuery->from->id);
    }
}
