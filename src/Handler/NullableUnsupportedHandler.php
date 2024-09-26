<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use Psr\Log\LoggerInterface;
use Temkaa\Botifier\Model\Shared\Message;

final readonly class NullableUnsupportedHandler implements UnsupportedHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function handle(Message $message): void
    {
        // TODO: add just log here
    }
}
