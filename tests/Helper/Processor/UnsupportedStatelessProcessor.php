<?php

declare(strict_types=1);

namespace Tests\Helper\Processor;

use Psr\Log\LoggerInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Processor\UnsupportedStatelessProcessorInterface;

final readonly class UnsupportedStatelessProcessor implements UnsupportedStatelessProcessorInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function process(Update $update): void
    {
        $this->logger->warning('something went wrong');
    }
}
