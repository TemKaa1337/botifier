<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber;

use Temkaa\Botifier\Subscriber\Signal\SubscriberInterface;
use Temkaa\Signal\SignalManagerInterface;

/**
 * @internal
 */
final readonly class SignalSubscriber implements SignalSubscriberInterface
{
    /**
     * @param SubscriberInterface[] $signalSubscribers
     */
    public function __construct(
        private array $signalSubscribers,
        private SignalManagerInterface $signalManager,
    ) {
        foreach ($signalSubscribers as $signalSubscriber) {
            if ($signalSubscriber->supportsOs(PHP_OS_FAMILY)) {
                $this->signalManager->subscribe($signalSubscriber, $signalSubscriber->getSubscribedSignal());
            }
        }
    }

    public function terminate(): bool
    {
        foreach ($this->signalSubscribers as $signalSubscriber) {
            if ($signalSubscriber->supportsOs(PHP_OS_FAMILY) && $signalSubscriber->isTriggered()) {
                return true;
            }
        }

        return false;
    }
}
