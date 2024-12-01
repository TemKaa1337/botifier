<?php

declare(strict_types=1);

namespace Tests\Helper\Service\Handler;

use Psr\Log\LoggerInterface;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;

final readonly class CustomUnsupportedMessageHandler implements UnsupportedHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function handle(Update $update): void
    {
        $this->logger->warning('This message type is unsupported');
    }
}
