<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

/**
 * @internal
 */
final class SigquitSubscriber extends AbstractSubscriber
{
    public function getSubscribedSignal(): int
    {
        return SIGQUIT;
    }

    public function supportsOs(string $os): bool
    {
        return $os === 'Linux';
    }
}
