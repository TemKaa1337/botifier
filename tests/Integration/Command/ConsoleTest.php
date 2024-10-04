<?php

declare(strict_types=1);

namespace Command;

use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Command\Console;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Tests\Helper\StreamInterceptor;

final class ConsoleTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /** @psalm-suppress UnusedFunctionCall */
        stream_filter_register(StreamInterceptor::getFilterName(), StreamInterceptor::class);
        stream_filter_append(STDOUT, StreamInterceptor::getFilterName());
    }

    public function testExecuteWithNonExistingCommand(): void
    {
        $console = new Console([]);
        $exitCode = $console->execute(['bin/botifier', 'non_existing_command']);

        self::assertSame(ExitCode::Failure->value, $exitCode);
        self::assertSame(
            implode(
                PHP_EOL,
                [
                    'There is no command with signature: "non_existing_command".',
                    'Fell free to check the list of allowed commands by using "bin/botifier help" command!',
                    '',
                ],
            ),
            StreamInterceptor::getBuffer(),
        );
    }

    public function testExecuteWithoutArguments(): void
    {
        $console = new Console([]);
        $exitCode = $console->execute(['bin/botifier']);

        self::assertSame(ExitCode::Success->value, $exitCode);
        self::assertSame(
            implode(
                PHP_EOL,
                [
                    'This script can execute a few useful commands!',
                    'Fell free to check the list of allowed commands by using "bin/console help" command!',
                    '',
                ],
            ),
            StreamInterceptor::getBuffer(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        StreamInterceptor::reset();
    }
}
