<?php

declare(strict_types=1);

namespace Tests\Helper\DependencyInjection;

use Temkaa\Botifier\DependencyInjection\ConfigProvider as BaseConfigProvider;
use Temkaa\Botifier\Service\TelegramClientInterface;
use Temkaa\Container\Model\Config;
use Temkaa\Container\Provider\Config\ProviderInterface;
use Tests\Helper\Service\TelegramClient;

final readonly class ConfigProvider implements ProviderInterface
{
    public function provide(): Config
    {
        $baseProvider = new BaseConfigProvider();

        return $baseProvider
            ->getBaseConfig()
            ->bindInterface(TelegramClientInterface::class, TelegramClient::class)
            ->build();
    }
}
