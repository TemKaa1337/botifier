<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @internal
 */
abstract class AbstractSubscriber implements SubscriberInterface
{
    private bool $isTriggered = false;

    public function __construct(
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function handle(): void
    {
        $this->isTriggered = true;

        $subscribedSignal = $this->getSubscribedSignal();

        $this->logger->warning(sprintf('Received "%s" signal.', $subscribedSignal));
    }

    public function isTriggered(): bool
    {
        return $this->isTriggered;
    }
}
