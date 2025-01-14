<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service\Conversation;

use Temkaa\Botifier\Model\CurrentConversation;

interface StorageInterface
{
    /**
     * Returns true on success, false otherwise
     */
    public function delete(int|string $chatId, int $userId): bool;

    /**
     * Returns Conversation object on success, null if conversation is not found
     */
    public function get(int|string $chatId, int $userId): ?CurrentConversation;

    /**
     * Returns true on success, false otherwise
     */
    public function set(CurrentConversation $currentConversation): bool;
}
