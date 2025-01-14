<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Builder;

use Composer\Autoload\ClassLoader;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use SensitiveParameter;
use Temkaa\Botifier\DependencyInjection\ConfigProvider;
use Temkaa\Botifier\Exception\Config\InvalidConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Processor\NullUnsupportedConversationProcessor;
use Temkaa\Botifier\Processor\NullUnsupportedStatelessProcessor;
use Temkaa\Botifier\Processor\UnsupportedConversationProcessorInterface;
use Temkaa\Botifier\Processor\UnsupportedStatelessProcessorInterface;
use Temkaa\Botifier\Provider\Conversation\SearchIdentifierProvider;
use Temkaa\Botifier\Provider\Conversation\SearchIdentifierProviderInterface;
use Temkaa\Botifier\Provider\Conversation\StartIdentifierProvider;
use Temkaa\Botifier\Provider\Conversation\StartIdentifierProviderInterface;
use Temkaa\Botifier\Provider\Webhook\UpdateProvider;
use Temkaa\Botifier\Provider\Webhook\UpdateProviderInterface;
use Temkaa\Botifier\RunnerInterface;
use Temkaa\Botifier\Service\Conversation\FileStorage;
use Temkaa\Botifier\Service\Conversation\Manager;
use Temkaa\Botifier\Service\Conversation\StorageInterface;
use Temkaa\Botifier\Service\Telegram\Client;
use Temkaa\Botifier\Service\Telegram\ClientInterface;
use Temkaa\Botifier\Subscriber\SignalSubscriber;
use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;
use Temkaa\Botifier\WebhookRunner;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ContainerBuilder;
use Temkaa\Container\Model\Config;
use Temkaa\Container\Provider\Config\ProviderInterface;
use function array_map;
use function array_unique;
use function class_implements;
use function dirname;
use function in_array;
use function is_dir;
use function is_file;
use function is_string;
use function is_writable;
use function mkdir;
use function realpath;
use function sprintf;
use const DIRECTORY_SEPARATOR;

/**
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @psalm-suppress MissingConstructor, RedundantPropertyInitializationCheck
 *
 * @TODO           : withCallbackHandler for non-container usage
 * @TODO: add default env(BOT_TOKEN) for bot token
 * @TODO: allow adding multiple container configs
 */
final class RunnerBuilder
{
    private Config|ProviderInterface $config;

    /**
     * @var class-string<SearchIdentifierProviderInterface>
     */
    private string $conversationSearchIdentifierProvider = SearchIdentifierProvider::class;

    /**
     * @var class-string<StartIdentifierProviderInterface>
     */
    private string $conversationStartIdentifierProvider = StartIdentifierProvider::class;

    /**
     * @var class-string<StorageInterface>
     */
    private string $conversationStorage = FileStorage::class;

    /**
     * @var class-string<ClientInterface>
     */
    private string $telegramClient = Client::class;

    /**
     * @var list<Conversation>
     */
    private array $conversations = [];

    private string $fileConversationStoragePath;

    /**
     * @var class-string<LoggerInterface>
     */
    private string $logger;

    /**
     * @var list<string> $pollingAllowedUpdates
     */
    private array $pollingAllowedUpdates = [];

    private float $pollingInterval = PollingRunner::DEFAULT_POLLING_INTERVAL;

    /**
     * @var class-string<RunnerInterface>
     */
    private string $runner = PollingRunner::class;

    private string $token;

    /**
     * @var class-string<UnsupportedConversationProcessorInterface>
     */
    private string $unsupportedStatefulProcessor = NullUnsupportedConversationProcessor::class;

    /**
     * @var class-string<UnsupportedStatelessProcessorInterface>
     */
    private string $unsupportedStatelessProcessor = NullUnsupportedStatelessProcessor::class;

    /**
     * @var class-string<UpdateProviderInterface>
     */
    private string $updateProvider = UpdateProvider::class;

    /**
     * @var class-string<SignalSubscriberInterface>
     */
    private string $signalSubscriber = SignalSubscriber::class;

    public function addConversation(Conversation $conversation): self
    {
        $instance = clone $this;
        $conversations = $instance->conversations;
        $conversations[] = $conversation;

        $instance->conversations = $conversations;

        return $instance;
    }

    public function build(): RunnerInterface
    {
        if (!isset($this->token)) {
            throw new InvalidConfigurationException('Bot token is required.');
        }

        if (!isset($this->config)) {
            throw new InvalidConfigurationException('User-defined config is required.');
        }

        $conversationEntrypoints = array_map(
            static fn (Conversation $conversation): string => $conversation->entrypoint,
            $this->conversations,
        );

        if ($conversationEntrypoints !== array_unique($conversationEntrypoints)) {
            throw new InvalidConfigurationException('All conversation entrypoints must be unique.');
        }

        $configBuilder = (new ConfigProvider())
            ->getBuilder()
            ->bindInterface(UnsupportedConversationProcessorInterface::class, $this->unsupportedStatefulProcessor)
            ->bindInterface(UnsupportedStatelessProcessorInterface::class, $this->unsupportedStatelessProcessor)
            ->bindInterface(RunnerInterface::class, $this->runner)
            ->bindInterface(StorageInterface::class, $this->conversationStorage)
            ->bindInterface(SearchIdentifierProviderInterface::class, $this->conversationSearchIdentifierProvider)
            ->bindInterface(StartIdentifierProviderInterface::class, $this->conversationStartIdentifierProvider)
            ->bindInterface(UpdateProviderInterface::class, $this->updateProvider)
            ->bindInterface(ClientInterface::class, $this->telegramClient)
            ->bindInterface(SignalSubscriberInterface::class, $this->signalSubscriber)
            ->configure(
                ClassBuilder::make(Client::class)
                    ->bindVariable('$token', $this->token)
                    ->build(),
            )
            ->configure(
                ClassBuilder::make(PollingRunner::class)
                    ->bindVariable('$pollingInterval', $this->pollingInterval)
                    ->bindVariable('$allowedUpdates', $this->pollingAllowedUpdates)
                    ->build(),
            )
            ->configure(
                ClassBuilder::make(Manager::class)
                    ->bindVariable('$conversations', $this->conversations)
                    ->build(),
            );

        if (isset($this->logger)) {
            $configBuilder->bindInterface(LoggerInterface::class, $this->logger);
        }

        if ($this->conversationStorage === FileStorage::class) {
            if (isset($this->fileConversationStoragePath)) {
                $storagePath = $this->fileConversationStoragePath;
            } else {
                $classLoaderFile = (new ReflectionClass(ClassLoader::class))->getFileName();

                $storagePath = sprintf(
                    '%s%s%s%s%s',
                    dirname($classLoaderFile, 3),
                    DIRECTORY_SEPARATOR,
                    'var',
                    DIRECTORY_SEPARATOR,
                    'conversations',
                );
            }

            if (is_file($storagePath)) {
                throw new InvalidConfigurationException(
                    sprintf(
                        'A directory for storing conversations "%s" must be a directory, file provided.',
                        $storagePath,
                    ),
                );
            }

            if (is_dir($storagePath)) {
                if (!is_writable($storagePath)) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'A directory for storing conversations "%s" is not writable, make it writable or provide other path.',
                            $storagePath,
                        ),
                    );
                }
            } else if (!mkdir($storagePath, 0755, true) && !is_dir($storagePath)) {
                throw new InvalidConfigurationException(
                    sprintf(
                        'Cannot create directory "%s" for storing conversations.',
                        $storagePath,
                    ),
                );
            }

            $configBuilder->configure(
                ClassBuilder::make(FileStorage::class)
                    ->bindVariable('$path', realpath($storagePath))
                    ->build(),
            );
        }

        $container = ContainerBuilder::make()
            ->add($configBuilder->build())
            ->add($this->config)
            ->build();

        return $container->get(RunnerInterface::class);
    }

    /**
     * @param list<string> $allowedUpdates
     */
    public function withAllowedUpdates(array $allowedUpdates): self
    {
        // TODO: bind in polling runner and for set webhook action
        foreach ($allowedUpdates as $allowedUpdate) {
            if (!is_string($allowedUpdate)) {
                throw new InvalidConfigurationException('Allowed updates must be a list of strings.');
            }
        }

        $instance = clone $this;
        $instance->pollingAllowedUpdates = $allowedUpdates;

        return $instance;
    }

    public function withConfig(Config|ProviderInterface $config): self
    {
        $instance = clone $this;
        $instance->config = $config;

        return $instance;
    }

    /**
     * @param class-string<SearchIdentifierProviderInterface> $provider
     */
    public function withConversationSearchIdentifierProvider(string $provider): self
    {
        if (!in_array(SearchIdentifierProviderInterface::class, class_implements($provider), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Conversation search identifier provider must implement "%s" interface.',
                    SearchIdentifierProviderInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->conversationSearchIdentifierProvider = $provider;

        return $instance;
    }

    /**
     * @param class-string<StartIdentifierProviderInterface> $provider
     */
    public function withConversationStartIdentifierProvider(string $provider): self
    {
        if (!in_array(StartIdentifierProviderInterface::class, class_implements($provider), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Conversation start identifier provider must implement "%s" interface.',
                    StartIdentifierProviderInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->conversationStartIdentifierProvider = $provider;

        return $instance;
    }

    /**
     * @param class-string<StorageInterface> $storage
     */
    public function withConversationStorage(string $storage): self
    {
        if (!in_array(StorageInterface::class, class_implements($storage), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Conversation storage must implement "%s" interface.',
                    StorageInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->conversationStorage = $storage;

        return $instance;
    }

    public function withFileConversationStoragePath(string $path): self
    {
        $instance = clone $this;
        $instance->fileConversationStoragePath = $path;

        return $instance;
    }

    /**
     * @param class-string<LoggerInterface> $logger
     */
    public function withLogger(string $logger): self
    {
        if (!in_array(LoggerInterface::class, class_implements($logger), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Logger must implement "%s" interface.',
                    LoggerInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->logger = $logger;

        return $instance;
    }

    public function withPollingInterval(float $pollingInterval): self
    {
        if ($pollingInterval < 0.0) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Polling interval for "%s" must be a positive number, "%s" given.',
                    PollingRunner::class,
                    $pollingInterval,
                ),
            );
        }

        $instance = clone $this;
        $instance->pollingInterval = $pollingInterval;

        return $instance;
    }

    /**
     * @param class-string<WebhookRunner|PollingRunner|RunnerInterface> $runner
     *
     * @return $this
     */
    public function withRunner(string $runner): self
    {
        if (!in_array(RunnerInterface::class, class_implements($runner), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Runner "%s" must implement "%s" interface.',
                    $runner,
                    RunnerInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->runner = $runner;

        return $instance;
    }

    public function withToken(#[SensitiveParameter] string $token): self
    {
        $instance = clone $this;
        $instance->token = $token;

        return $instance;
    }

    /**
     * @param class-string<UnsupportedConversationProcessorInterface> $processor
     */
    public function withUnsupportedStatefulProcessor(string $processor): self
    {
        if (!in_array(UnsupportedConversationProcessorInterface::class, class_implements($processor), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Unsupported stateful processor "%s" must implement "%s" interface.',
                    $processor,
                    UnsupportedConversationProcessorInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->unsupportedStatefulProcessor = $processor;

        return $instance;
    }

    /**
     * @param class-string<UnsupportedStatelessProcessorInterface> $processor
     */
    public function withUnsupportedStatelessProcessor(string $processor): self
    {
        if (!in_array(UnsupportedStatelessProcessorInterface::class, class_implements($processor), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Unsupported stateless processor "%s" must implement "%s" interface.',
                    $processor,
                    UnsupportedStatelessProcessorInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->unsupportedStatelessProcessor = $processor;

        return $instance;
    }

    /**
     * This should be used only for testing purposes and only for WebhookRunner
     *
     * @param class-string<UpdateProviderInterface> $provider
     */
    public function withUpdateProvider(string $provider): self
    {
        if (!in_array(UpdateProviderInterface::class, class_implements($provider), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Update provider must implement "%s" interface.',
                    UpdateProviderInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->updateProvider = $provider;

        return $instance;
    }

    /**
     * This should be used only for testing purposes
     *
     * @param class-string<ClientInterface> $client
     */
    public function withTelegramClient(string $client): self
    {
        if (!in_array(ClientInterface::class, class_implements($client), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Update provider must implement "%s" interface.',
                    ClientInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->telegramClient = $client;

        return $instance;
    }

    /**
     * This should be used only for testing purposes and only using PollingRunner
     *
     * @param class-string<SignalSubscriberInterface> $subscriber
     */
    public function withSignalSubscriber(string $subscriber): self
    {
        if (!in_array(SignalSubscriberInterface::class, class_implements($subscriber), true)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Signal subscriber must implement "%s" interface.',
                    SignalSubscriberInterface::class,
                ),
            );
        }

        $instance = clone $this;
        $instance->signalSubscriber = $subscriber;

        return $instance;
    }
}
