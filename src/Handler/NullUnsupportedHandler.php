<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Model\Response\Message;

/**
 * @internal
 */
final readonly class NullUnsupportedHandler implements UnsupportedHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function handle(Message $message): void
    {
        $this->logger->warning(sprintf('Could not find suitable handler for message "%s".', $message->getRaw()));
    }
}
