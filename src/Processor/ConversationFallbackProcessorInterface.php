<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Model\Response\Nested\Update;

interface ConversationFallbackProcessorInterface
{
    /**
     * Returns next state
     */
    public function process(Update $update, string $conversationName, string $stateName, Context $context): string;

    public function supports(Update $update): bool;
}
