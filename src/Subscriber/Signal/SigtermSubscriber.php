<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

/**
 * @internal
 */
final class SigtermSubscriber extends AbstractSubscriber
{
    public function getSubscribedSignal(): int
    {
        return SIGTERM;
    }

    public function supportsOs(string $os): bool
    {
        return $os === 'Linux';
    }
}
