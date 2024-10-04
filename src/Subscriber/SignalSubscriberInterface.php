<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber;

/**
 * @internal
 */
interface SignalSubscriberInterface
{
    public function terminate(): bool;
}
