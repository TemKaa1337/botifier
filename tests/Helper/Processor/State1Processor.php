<?php

declare(strict_types=1);

namespace Tests\Helper\Processor;

use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;

final readonly class State1Processor implements ConversationProcessorInterface
{
    public function process(Update $update, Context $context): string
    {
        $context->set(self::class, 'test');

        return 'state2';
    }

    public function supports(Update $update): bool
    {
        return $update->callbackQuery?->data === 'state1';
    }
}
