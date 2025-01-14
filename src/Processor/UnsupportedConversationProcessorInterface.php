<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Model\Response\Nested\Update;

interface UnsupportedConversationProcessorInterface
{
    public function process(Update $update, string $conversation, string $state, Context $context): void;
}
