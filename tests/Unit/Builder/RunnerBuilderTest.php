<?php

declare(strict_types=1);

namespace Builder;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Temkaa\Botifier\Builder\ConversationBuilder;
use Temkaa\Botifier\Builder\RunnerBuilder;
use Temkaa\Botifier\Exception\Config\InvalidConfigurationException;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Processor\UnsupportedConversationProcessorInterface;
use Temkaa\Botifier\Processor\UnsupportedStatelessProcessorInterface;
use Temkaa\Botifier\Provider\Conversation\SearchIdentifierProviderInterface;
use Temkaa\Botifier\Provider\Conversation\StartIdentifierProviderInterface;
use Temkaa\Botifier\Provider\Webhook\UpdateProviderInterface;
use Temkaa\Botifier\RunnerInterface;
use Temkaa\Botifier\Service\Conversation\StorageInterface;
use Temkaa\Botifier\Service\Telegram\ClientInterface;
use Temkaa\Botifier\Subscriber\SignalSubscriberInterface;
use Temkaa\Container\Builder\ConfigBuilder;
use Tests\Helper\Processor\CommandProcessor;
use Tests\Helper\Service\EmptyClass;
use Throwable;
use function sprintf;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class RunnerBuilderTest extends TestCase
{
    /**
     * @return iterable<array{0: string, 1: class-string<Throwable>, 2: string}>
     */
    public static function getDataForFailsWithCallingConfigurationMethodsWithoutNeededClassesTest(): iterable
    {
        yield [
            'withConversationSearchIdentifierProvider',
            InvalidConfigurationException::class,
            sprintf(
                'Conversation search identifier provider must implement "%s" interface.',
                SearchIdentifierProviderInterface::class,
            ),
        ];
        yield [
            'withConversationStartIdentifierProvider',
            InvalidConfigurationException::class,
            sprintf(
                'Conversation start identifier provider must implement "%s" interface.',
                StartIdentifierProviderInterface::class,
            ),
        ];
        yield [
            'withConversationStorage',
            InvalidConfigurationException::class,
            sprintf(
                'Conversation storage must implement "%s" interface.',
                StorageInterface::class,
            ),
        ];
        yield [
            'withLogger',
            InvalidConfigurationException::class,
            sprintf(
                'Logger must implement "%s" interface.',
                LoggerInterface::class,
            ),
        ];
        yield [
            'withRunner',
            InvalidConfigurationException::class,
            sprintf(
                'Runner "%s" must implement "%s" interface.',
                EmptyClass::class,
                RunnerInterface::class,
            ),
        ];
        yield [
            'withUnsupportedStatefulProcessor',
            InvalidConfigurationException::class,
            sprintf(
                'Unsupported stateful processor "%s" must implement "%s" interface.',
                EmptyClass::class,
                UnsupportedConversationProcessorInterface::class,
            ),
        ];
        yield [
            'withUnsupportedStatelessProcessor',
            InvalidConfigurationException::class,
            sprintf(
                'Unsupported stateless processor "%s" must implement "%s" interface.',
                EmptyClass::class,
                UnsupportedStatelessProcessorInterface::class,
            ),
        ];
        yield [
            'withUpdateProvider',
            InvalidConfigurationException::class,
            sprintf(
                'Update provider must implement "%s" interface.',
                UpdateProviderInterface::class,
            ),
        ];
        yield [
            'withTelegramClient',
            InvalidConfigurationException::class,
            sprintf(
                'Update provider must implement "%s" interface.',
                ClientInterface::class,
            ),
        ];
        yield [
            'withSignalSubscriber',
            InvalidConfigurationException::class,
            sprintf(
                'Signal subscriber must implement "%s" interface.',
                SignalSubscriberInterface::class,
            ),
        ];
    }

    public function testDoesNotCompileWithoutRequiredConfigurationMethods(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage('Bot token is required.');

        (new RunnerBuilder())
            ->withConfig(ConfigBuilder::make()->build())
            ->build();

        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage('User-defined config is required.');

        (new RunnerBuilder())
            ->withToken('token')
            ->build();
    }

    /**
     * @param class-string<Throwable> $expectedException
     */
    #[DataProvider('getDataForFailsWithCallingConfigurationMethodsWithoutNeededClassesTest')]
    public function testFailsWithCallingConfigurationMethodsWithoutNeededClasses(
        string $methodName,
        string $expectedException,
        string $expectedExceptionMessage,
    ): void {
        $builder = new RunnerBuilder();

        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $builder->{$methodName}(EmptyClass::class);
    }

    public function testFailsWithDuplicatedEntrypoint(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage('All conversation entrypoints must be unique.');

        (new RunnerBuilder())
            ->withToken('token')
            ->withConfig(ConfigBuilder::make()->build())
            ->addConversation(
                (new ConversationBuilder())
                    ->name('name')
                    ->entrypoint(CommandProcessor::class)
                    ->startState('startState')
                    ->endState('endState')
                    ->addState(
                        new State('startState', processors: []),
                    )
                    ->addState(
                        new State('state', processors: []),
                    )
                    ->build(),
            )
            ->addConversation(
                (new ConversationBuilder())
                    ->name('name2')
                    ->entrypoint(CommandProcessor::class)
                    ->startState('startState')
                    ->endState('endState')
                    ->addState(
                        new State('startState', processors: []),
                    )
                    ->addState(
                        new State('state', processors: []),
                    )
                    ->build(),
            )
            ->build();
    }

    public function testFailsWithInvalidPollingInterval(): void
    {
        $interval = -0.1;
        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Polling interval for "%s" must be a positive number, "%s" given.',
                PollingRunner::class,
                $interval,
            ),
        );

        (new RunnerBuilder())->withPollingInterval($interval);
    }

    public function testFailsWithFileAsStorageFilePath(): void
    {
        $fileName = (new ReflectionClass(self::class))->getFileName();

        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage(
            sprintf('A directory for storing conversations "%s" must be a directory, file provided.', $fileName)
        );

        (new RunnerBuilder())
            ->withToken('token')
            ->withConfig(ConfigBuilder::make()->build())
            ->withFileConversationStoragePath($fileName)
            ->build();
    }
}
