<?php

declare(strict_types=1);

namespace Tests\Integration\Runner;

use Composer\Autoload\ClassLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Temkaa\Botifier\Builder\RunnerBuilder;
use Temkaa\Botifier\Model\Config\Conversation;
use Temkaa\Botifier\Processor\UnsupportedStatelessProcessorInterface;
use Temkaa\Botifier\RunnerInterface;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Model\Config;
use Tests\Helper\Processor\CallbackProcessor;
use Tests\Helper\Provider\Webhook\UpdateProvider;
use Tests\Helper\Service\Client;
use Tests\Helper\Subscriber\SignalSubscriber;
use function dirname;
use function is_dir;
use function md5;
use function rmdir;
use function sprintf;

abstract class AbstractRunnerTestCase extends TestCase
{
    protected static RunnerInterface $runner;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$runner = self::getRunner();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        $path = __DIR__.'/../../../var/conversation';
        if (is_dir($path)) {
            rmdir($path);
        }
    }

    protected static function getDefaultContainerConfigBuilder(): ConfigBuilder
    {
        return ConfigBuilder::make()
            ->include((new ReflectionClass(CallbackProcessor::class))->getFileName());
    }

    protected function getConversationFolder(): string
    {
        $projectDirectory = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);

        return "$projectDirectory/var/conversations";
    }

    /**
     * @param list<Conversation>|null            $conversations
     * @param class-string<LoggerInterface>|null $logger
     * @param class-string<UnsupportedStatelessProcessorInterface>|null $unsupportedStatelessProcessor
     */
    protected static function getRunner(
        ?Config $config = null,
        ?array $conversations = null,
        ?string $logger = null,
        ?string $unsupportedStatelessProcessor = null,
    ): RunnerInterface {
        if (!$config) {
            $config = self::getDefaultContainerConfigBuilder()->build();
        }

        $builder = (new RunnerBuilder())
            ->withTelegramClient(Client::class)
            ->withUpdateProvider(UpdateProvider::class)
            ->withConfig($config)
            ->withRunner(static::getRunnerClass())
            ->withToken('bot_token')
            ->withPollingInterval(0.25)
            ->withSignalSubscriber(SignalSubscriber::class);

        if ($logger) {
            $builder = $builder->withLogger($logger);
        }

        if ($unsupportedStatelessProcessor) {
            $builder = $builder->withUnsupportedStatelessProcessor($unsupportedStatelessProcessor);
        }

        foreach ($conversations ?? [] as $conversation) {
            $builder = $builder->addConversation($conversation);
        }

        return $builder->build();
    }

    /**
     * @return class-string<RunnerInterface>
     */
    abstract protected static function getRunnerClass(): string;

    protected function executeRunner(): void
    {
        self::$runner->run();
    }

    protected function setUp(): void
    {
        parent::setUp();

        CallbackProcessor::reset();
        SignalSubscriber::reset();
        Client::reset();
    }
}
