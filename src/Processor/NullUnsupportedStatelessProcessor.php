<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Processor;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Temkaa\Botifier\Model\Response\Nested\Update;
use function sprintf;

final readonly class NullUnsupportedStatelessProcessor implements UnsupportedStatelessProcessorInterface
{
    public function __construct(
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function process(Update $update): void
    {
        $this->logger->debug(sprintf('Could not find suitable handler for update id "%s".', $update->updateId));
    }
}
