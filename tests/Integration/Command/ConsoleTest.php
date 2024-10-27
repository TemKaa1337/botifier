<?php

declare(strict_types=1);

namespace Command;

use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Command\Console;
use Temkaa\Botifier\Command\Handler\HelpCommand;
use Temkaa\Botifier\Command\Handler\SetDescriptionCommand;
use Temkaa\Botifier\DependencyInjection\Command\ConfigProvider;
use Temkaa\Botifier\Enum\Command\ExitCode;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\Service\TelegramClient;
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

    public function testCommandContainerBoots(): void
    {
        $container = ContainerBuilder::make()->add(new ConfigProvider())->build();
        self::assertNotNull($container);
    }

    public function testExecuteTestCommand(): void
    {
        $setSubscriptionCommand = new SetDescriptionCommand(new TelegramClient());
        $console = new Console([new HelpCommand([$setSubscriptionCommand]), $setSubscriptionCommand]);
        $exitCode = $console->execute(['bin/botifier help']);

        self::assertSame(ExitCode::Success->value, $exitCode);
        self::assertSame(
            implode(
                PHP_EOL,
                [
                    'description:set',
                    '  Description: This command allows you to set a description for your bot.',
                    '  Arguments:',
                    '    --token (required):        A token for your bot.',
                    '    --description (required):  A specified description for your bot.',
                    '    --language (required):     A specified language for provided description.',
                    '',
                ],
            ),
            StreamInterceptor::getBuffer(),
        );
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
        $setSubscriptionCommand = new SetDescriptionCommand(new TelegramClient());
        $console = new Console([new HelpCommand([$setSubscriptionCommand]), $setSubscriptionCommand]);
        $exitCode = $console->execute(['bin/botifier']);

        self::assertSame(ExitCode::Success->value, $exitCode);
        self::assertSame(
            implode(
                PHP_EOL,
                [
                    'description:set',
                    '  Description: This command allows you to set a description for your bot.',
                    '  Arguments:',
                    '    --token (required):        A token for your bot.',
                    '    --description (required):  A specified description for your bot.',
                    '    --language (required):     A specified language for provided description.',
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
