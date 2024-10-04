<?php

declare(strict_types=1);

namespace Tests\Helper\DependencyInjection;

use Temkaa\Botifier\DependencyInjection\ConfigProvider as BaseConfigProvider;
use Temkaa\Botifier\Handler\HandlerInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Service\TelegramClientInterface;
use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Model\Config;
use Temkaa\Container\Provider\Config\ProviderInterface;
use Tests\Helper\Service\TelegramClient;
use Tests\Helper\Subscriber\SignalSubscriber;

final readonly class ConfigProvider implements ProviderInterface
{
    public function getBuilder(): ConfigBuilder
    {
        $baseProvider = new BaseConfigProvider();

        return $baseProvider
            ->getBuilder()
            ->include(__DIR__.'/../Service/Handler/CallbackHandler.php')
            ->include(__DIR__.'/../Service/TelegramClient.php')
            ->include(__DIR__.'/../Subscriber/SignalSubscriber.php')
            ->exclude(__DIR__.'/../../../src/Service/TelegramClient.php')
            ->bindInterface(TelegramClientInterface::class, TelegramClient::class)
            ->bindInterface(SignalSubscriberInterface::class, SignalSubscriber::class)
            ->bindClass(
                ClassBuilder::make(Bot::class)
                    ->bindVariable('token', 'test_token')
                    ->build(),
            )
            ->bindClass(
                ClassBuilder::make(PollingRunner::class)
                    ->bindVariable('handlers', new InstanceOfIterator(HandlerInterface::class))
                    ->bindVariable('pollingInterval', '0.25')
                    ->build(),
            );
    }

    public function provide(): Config
    {
        return $this->getBuilder()->build();
    }
}
