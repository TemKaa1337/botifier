<?php

declare(strict_types=1);

namespace Tests\Helper\Subscriber;

use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;

final class SignalSubscriber implements SignalSubscriberInterface
{
    private array $terminations = [false, true];

    public function terminate(): bool
    {
        return array_shift($this->terminations);
    }
}
