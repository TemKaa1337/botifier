<?php

declare(strict_types=1);

namespace Tests\Helper\Service\Handler;

use Closure;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;

final class CallbackHandler implements HandlerInterface
{
    private static ?Closure $handleCallback = null;

    private static ?Closure $supportsCallback = null;

    public static function reset(): void
    {
        self::$handleCallback = null;
        self::$supportsCallback = null;
    }

    public static function setHandleCallback(Closure $callback): void
    {
        self::$handleCallback = $callback;
    }

    public static function setSupportsCallback(Closure $callback): void
    {
        self::$supportsCallback = $callback;
    }

    public function handle(Update $update): void
    {
        (self::$handleCallback)($update);
    }

    public function supports(Update $update): bool
    {
        return self::$supportsCallback !== null ? (self::$supportsCallback)($update) : false;
    }
}
