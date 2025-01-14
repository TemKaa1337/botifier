<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Provider\Conversation;

use Temkaa\Botifier\Model\CurrentConversation\Identifier;
use Temkaa\Botifier\Model\Response\Nested\Update;

interface IdentifierProviderInterface
{
    public function provide(Update $update): ?Identifier;
}
