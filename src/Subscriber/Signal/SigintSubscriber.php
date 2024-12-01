<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

/**
 * @internal
 */
final class SigintSubscriber extends AbstractSubscriber
{
    public function getSubscribedSignal(): int
    {
        return SIGINT;
    }

    public function supportsOs(string $os): bool
    {
        return $os === 'Linux';
    }
}
