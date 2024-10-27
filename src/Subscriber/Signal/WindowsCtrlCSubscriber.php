<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

/**
 * @internal
 */
final class WindowsCtrlCSubscriber extends AbstractSubscriber
{
    public function getSubscribedSignal(): int
    {
        return PHP_WINDOWS_EVENT_CTRL_C;
    }

    public function supportsOs(string $os): bool
    {
        return $os === 'Windows';
    }
}
