<?php

declare(strict_types=1);

namespace Tests\Helper\Subscriber;

use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;
use function array_shift;

final class SignalSubscriber implements SignalSubscriberInterface
{
    private static array $terminations = [false, true];

    public function terminate(): bool
    {
        return array_shift(self::$terminations);
    }

    public static function reset(): void
    {
        self::$terminations = [false, true];
    }
}
