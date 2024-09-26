<?php

declare(strict_types=1);

namespace Tests\Integration\Runner;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use Temkaa\Botifier\RunnerInterface;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\DependencyInjection\ConfigProvider;

abstract class AbstractRunnerTestCase extends TestCase
{
    private readonly ContainerInterface $container;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getRunner(string $runner): RunnerInterface
    {
        return $this->container->get($runner);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->container = ContainerBuilder::make()->add(new ConfigProvider())->build();
    }
}
