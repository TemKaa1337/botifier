<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Subscriber\Signal;

/**
 * @internal
 */
final class WindowsCtrlBreakSubscriber extends AbstractSubscriber
{
    public function getSubscribedSignal(): int
    {
        return PHP_WINDOWS_EVENT_CTRL_BREAK;
    }

    public function supportsOs(string $os): bool
    {
        return $os === 'Windows';
    }
}
