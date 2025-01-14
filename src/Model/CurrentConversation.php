<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Model\CurrentConversation\Context;

final readonly class CurrentConversation
{
    // TODO: move those 2 properties to single object identifier
    public function __construct(
        public int|string $chatId,
        public int $userId,
        public string $name,
        public string $state,
        public Context $context,
        public UnprocessedStrategy $unprocessedStrategy,
    ) {
    }

    public function transitState(string $state): self
    {
        return new self($this->chatId, $this->userId, $this->name, $state, $this->context, $this->unprocessedStrategy);
    }
}
