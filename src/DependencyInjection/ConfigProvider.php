<?php

declare(strict_types=1);

namespace Temkaa\Botifier\DependencyInjection;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use ReflectionClass;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\ResponseFactory;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Processor\ConversationFallbackProcessorInterface;
use Temkaa\Botifier\Processor\ConversationProcessorInterface;
use Temkaa\Botifier\Processor\StatelessProcessorInterface;
use Temkaa\Botifier\Processor\UpdateProcessor;
use Temkaa\Botifier\Service\Telegram\Client as TelegramClient;
use Temkaa\Botifier\Subscriber\SignalSubscriber;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Enum\Attribute\Bind\IteratorFormat;
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
            ->exclude(__DIR__.'/../Model/')
            ->include((new ReflectionClass(Client::class))->getFileName())
            ->include((new ReflectionClass(HttpFactory::class))->getFileName())
            ->include((new ReflectionClass(SignalManager::class))->getFileName())
            ->configure(
                ClassBuilder::make(SignalSubscriber::class)
                    ->bindVariable('$signalSubscribers', new InstanceOfIterator(SignalSubscriberInterface::class))
                    ->build(),
            )
            ->configure(
                ClassBuilder::make(ResponseFactory::class)
                    ->bindVariable('factories', new InstanceOfIterator(FactoryInterface::class))
                    ->build(),
            )
            ->configure(
                ClassBuilder::make(UpdateProcessor::class)
                    ->bindVariable(
                        '$statefulFallbackProcessors',
                        new InstanceOfIterator(
                            ConversationFallbackProcessorInterface::class,
                            format: IteratorFormat::ArrayWithClassNamespaceKey,
                        ),
                    )
                    ->bindVariable(
                        '$statefulProcessors',
                        new InstanceOfIterator(
                            ConversationProcessorInterface::class,
                            format: IteratorFormat::ArrayWithClassNamespaceKey,
                        ),
                    )
                    ->bindVariable('$statelessProcessors', new InstanceOfIterator(StatelessProcessorInterface::class))
                    ->build(),
            );
    }

    public function provide(): Config
    {
        return $this->getBuilder()->build();
    }
}
