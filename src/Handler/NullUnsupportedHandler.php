<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @internal
 */
final readonly class NullUnsupportedHandler implements UnsupportedHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function handle(Update $update): void
    {
        $this->logger->warning(sprintf('Could not find suitable handler for update id "%s".', $update->updateId));
    }
}
