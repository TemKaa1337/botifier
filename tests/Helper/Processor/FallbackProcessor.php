<?php

declare(strict_types=1);

namespace Tests\Helper\Processor;

use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;

final readonly class FallbackProcessor implements ConversationFallbackProcessorInterface
{
    public function process(Update $update, string $conversationName, string $stateName, Context $context): string
    {
        return 'end';
    }

    public function supports(Update $update): bool
    {
        return $update->callbackQuery?->data === 'fallback1';
    }
}
