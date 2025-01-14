<?php

declare(strict_types=1);

namespace Tests\Helper\Processor;

use Closure;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;

final class CallbackProcessor implements StatelessProcessorInterface
{
    /**
     * @var Closure(Update $update): void|null
     */
    private static ?Closure $handleCallback = null;

    /**
     * @var Closure(Update $update): bool|null
     */
    private static ?Closure $supportsCallback = null;

    public static function reset(): void
    {
        self::$handleCallback = null;
        self::$supportsCallback = null;
    }

    /**
     * @param Closure(Update $update): void $callback
     */
    public static function setHandleCallback(Closure $callback): void
    {
        self::$handleCallback = $callback;
    }

    /**
     * @param Closure(Update $update): bool $callback
     */
    public static function setSupportsCallback(Closure $callback): void
    {
        self::$supportsCallback = $callback;
    }

    public function supports(Update $update): bool
    {
        return self::$supportsCallback !== null ? (self::$supportsCallback)($update) : false;
    }

    public function process(Update $update): void
    {
        (self::$handleCallback)($update);
    }
}
