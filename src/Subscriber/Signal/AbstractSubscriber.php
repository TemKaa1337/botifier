<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

use Psr\Log\LoggerInterface;

abstract class AbstractSubscriber implements SubscriberInterface
{
    private const array SIGNAL_SIGNATURE_MAP = [
        0  => 'PHP_WINDOWS_EVENT_CTRL_C',
        1  => 'PHP_WINDOWS_EVENT_CTRL_BREAK',
        15 => 'SIGTERM',
    ];

    private bool $isTriggered = false;

    public function __construct(
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    public function handle(): void
    {
        $this->isTriggered = true;

        $subscribedSignal = $this->getSubscribedSignal();

        $this->logger?->warning(
            sprintf(
                'Received signal with "%s" signature.',
                self::SIGNAL_SIGNATURE_MAP[$subscribedSignal] ?? $subscribedSignal,
            ),
        );
    }

    public function isTriggered(): bool
    {
        return $this->isTriggered;
    }
}
