<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

use Temkaa\Signal\SignalSubscriberInterface;

/**
 * @internal
 */
interface SubscriberInterface extends SignalSubscriberInterface
{
    public function getSubscribedSignal(): int;

    public function isTriggered(): bool;

    public function supportsOs(string $os): bool;
}
