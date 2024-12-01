<?php

declare(strict_types=1);

namespace Temkaa\Botifier\DependencyInjection\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use ReflectionClass;
use Temkaa\Botifier\Command\CommandInterface;
use Temkaa\Botifier\Command\Console;
use Temkaa\Botifier\Command\Handler\HelpCommand;
use Temkaa\Botifier\Factory\ResponseFactory;
use Temkaa\Botifier\Interface\Response\FactoryInterface;
use Temkaa\Botifier\Service\TelegramClient;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Model\Config;
use Temkaa\Container\Provider\Config\ProviderInterface;

/**
 * @internal
 */
final readonly class ConfigProvider implements ProviderInterface
{
    public function provide(): Config
    {
        return ConfigBuilder::make()
            ->include(__DIR__.'/../../Command/')
            ->include(__DIR__.'/../../Service/')
            ->include(__DIR__.'/../../Factory/')
            ->exclude(__DIR__.'/../../Model/')
            ->include((new ReflectionClass(Client::class))->getFileName())
            ->include((new ReflectionClass(HttpFactory::class))->getFileName())
            ->exclude(__DIR__.'/../../Command/Input.php')
            ->exclude(__DIR__.'/../../Command/Output.php')
            ->bindClass(
                ClassBuilder::make(TelegramClient::class)
                    ->bindVariable('token', 'env(BOT_TOKEN)')
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(HelpCommand::class)
                    ->bindVariable(
                        'commands',
                        new InstanceOfIterator(
                            CommandInterface::class,
                            exclude: [HelpCommand::class],
                        ),
                    )
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(Console::class)
                    ->bindVariable('commands', new InstanceOfIterator(CommandInterface::class))
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(ResponseFactory::class)
                    ->bindVariable('factories', new InstanceOfIterator(FactoryInterface::class))
                    ->build(),
            )
            ->build();
    }
}
