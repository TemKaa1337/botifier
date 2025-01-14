<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Model\CurrentConversation\Context;
use Temkaa\Botifier\Model\Response\Nested\Update;
use function sprintf;

final readonly class NullUnsupportedConversationProcessor implements UnsupportedConversationProcessorInterface
{
    public function __construct(
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function process(Update $update, string $conversation, string $state, Context $context): void
    {
        $this->logger->debug(
            sprintf(
                'Could not find suitable stateful handler for update id "%s", conversation: "%s", state: "%s".',
                $update->updateId,
                $conversation,
                $state,
            ),
        );
    }
}
