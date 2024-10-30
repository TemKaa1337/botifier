<?php

declare(strict_types=1);

namespace Temkaa\Botifier\DependencyInjection;

use ReflectionClass;
use Temkaa\Botifier\Factory\Message\Content\UnknownContentFactory;
use Temkaa\Botifier\Factory\Message\ContentFactory;
use Temkaa\Botifier\Factory\Message\ContentFactoryInterface;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Serializer\Action\SerializerInterface;
use Temkaa\Botifier\Serializer\Serializer;
use Temkaa\Botifier\Subscriber\SignalSubscriber;
use Temkaa\Botifier\WebhookRunner;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Model\Config;
use Temkaa\Container\Provider\Config\ProviderInterface;
use Temkaa\Signal\SignalManager;
use Temkaa\Signal\SignalSubscriberInterface;

/**
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final readonly class ConfigProvider implements ProviderInterface
{
    public function getBuilder(): ConfigBuilder
    {
        return ConfigBuilder::make()
            ->include(__DIR__.'/../')
            ->exclude(__DIR__.'/../Command/')
            ->exclude(__DIR__.'/Command')
            ->exclude(__DIR__.'/../Enum/')
            ->exclude(__DIR__.'/../Exception/')
            ->exclude(__DIR__.'/../Model/Request')
            ->exclude(__DIR__.'/../Model/Response')
            ->exclude(__DIR__.'/../Model/File.php')
            ->include((new ReflectionClass(SignalManager::class))->getFileName())
            ->bindClass(
                ClassBuilder::make(Bot::class)
                    ->bindVariable('token', 'env(BOT_TOKEN)')
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(SignalSubscriber::class)
                    ->bindVariable('$signalSubscribers', new InstanceOfIterator(SignalSubscriberInterface::class))
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(ContentFactory::class)
                    ->bindVariable(
                        'factories',
                        new InstanceOfIterator(
                            ContentFactoryInterface::class,
                            exclude: [UnknownContentFactory::class]
                        ),
                    )
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(PollingRunner::class)
                    ->bindVariable('handlers', new InstanceOfIterator(HandlerInterface::class))
                    ->bindVariable('pollingInterval', 'env(BOT_POLLING_INTERVAL)')
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(Serializer::class)
                    ->bindVariable('handlers', new InstanceOfIterator(SerializerInterface::class))
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(WebhookRunner::class)
                    ->bindVariable('handlers', new InstanceOfIterator(HandlerInterface::class))
                    ->build(),
            );
    }

    public function provide(): Config
    {
        return $this->getBuilder()->build();
    }
}
