<?php

declare(strict_types=1);

namespace Runner\WebhookRunner;

use DateTimeImmutable;
use JsonException;
use ReflectionClass;
use Temkaa\Botifier\Builder\ConversationBuilder;
use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\WebhookRunner;
use Tests\Helper\Processor\CommandProcessor;
use Tests\Helper\Processor\EntrypointProcessor;
use Tests\Helper\Processor\Fallback2Processor;
use Tests\Helper\Processor\FallbackProcessor;
use Tests\Helper\Processor\State1Processor;
use Tests\Helper\Processor\State2Processor;
use Tests\Helper\Provider\Webhook\UpdateProvider;
use Tests\Helper\Trait\Mock\UpdateMockTrait;
use Tests\Integration\Runner\AbstractRunnerTestCase;
use function file_get_contents;
use function json_decode;
use function md5;
use function sprintf;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
final class StatefulRunnerTest extends AbstractRunnerTestCase
{
    use UpdateMockTrait;

    protected static function getRunnerClass(): string
    {
        return WebhookRunner::class;
    }

    /**
     * @throws JsonException
     */
    public function testRunFullCycleOfConversationWithEndStateFallbacks(): void
    {
        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(EntrypointProcessor::class))->getFileName())
            ->include((new ReflectionClass(State1Processor::class))->getFileName())
            ->include((new ReflectionClass(State2Processor::class))->getFileName());

        UpdateProvider::setInput(
            $this->getTextMessage(message: 'please start a conversation', createdAt: new DateTimeImmutable()),
        );

        $runner = self::getRunner(
            config: $configBuilder
                ->include((new ReflectionClass(FallbackProcessor::class))->getFileName())
                ->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->addState(new State('state2', processors: [State2Processor::class]))
                    ->addFallback(FallbackProcessor::class)
                    ->endState('end')
                    ->build(),
            ],
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'fallback1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileDoesNotExist($conversationFileDirectory);
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     *
     * @throws JsonException
     */
    public function testRunFullCycleOfConversationWithNonEndStateFallbacks(): void
    {
        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(EntrypointProcessor::class))->getFileName())
            ->include((new ReflectionClass(State1Processor::class))->getFileName())
            ->include((new ReflectionClass(State2Processor::class))->getFileName())
            ->include((new ReflectionClass(Fallback2Processor::class))->getFileName());

        UpdateProvider::setInput(
            $this->getTextMessage(message: 'please start a conversation', createdAt: new DateTimeImmutable()),
        );

        $runner = self::getRunner(
            $configBuilder->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->addState(new State('state2', processors: [State2Processor::class]))
                    ->endState('end')
                    ->addFallback(Fallback2Processor::class)
                    ->build(),
            ],
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'fallback2',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state2',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileDoesNotExist($conversationFileDirectory);
    }

    /**
     * @throws JsonException
     */
    public function testRunFullCycleOfConversationWithoutFallbacks(): void
    {
        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(EntrypointProcessor::class))->getFileName())
            ->include((new ReflectionClass(State1Processor::class))->getFileName())
            ->include((new ReflectionClass(State2Processor::class))->getFileName());

        UpdateProvider::setInput(
            $this->getTextMessage(message: 'please start a conversation', createdAt: new DateTimeImmutable()),
        );

        $runner = self::getRunner(
            $configBuilder->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->addState(new State('state2', processors: [State2Processor::class]))
                    ->endState('end')
                    ->build(),
            ],
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state2',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileDoesNotExist($conversationFileDirectory);
    }

    /**
     * @throws JsonException
     */
    public function testConversationRewritesAfterReceivingNonConversationMessage(): void
    {
        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(EntrypointProcessor::class))->getFileName())
            ->include((new ReflectionClass(State1Processor::class))->getFileName())
            ->include((new ReflectionClass(State2Processor::class))->getFileName())
            ->include((new ReflectionClass(CommandProcessor::class))->getFileName());

        UpdateProvider::setInput(
            $this->getTextMessage(message: 'please start a conversation', createdAt: new DateTimeImmutable()),
        );

        $runner = self::getRunner(
            $configBuilder->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->addState(new State('state2', processors: [State2Processor::class]))
                    ->endState('end')
                    ->unprocessedStrategy(UnprocessedStrategy::ContinueProcessing)
                    ->build(),
                (new ConversationBuilder())
                    ->name('test conversation 2')
                    ->entrypoint(CommandProcessor::class)
                    ->startState('start 1')
                    ->addState(new State('start 1', processors: [State1Processor::class]))
                    ->addState(new State('state 2', processors: [State2Processor::class]))
                    ->endState('end')
                    ->unprocessedStrategy(UnprocessedStrategy::LeaveUnprocessed)
                    ->build(),
            ],
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::ContinueProcessing->value,
                'data'                => [],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::ContinueProcessing->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getTextMessage(
                message: '/command',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation 2',
                'state'               => 'start 1',
                'unprocessedStrategy' => UnprocessedStrategy::LeaveUnprocessed->value,
                'data'                => [],
            ],
            $conversationContent,
        );
    }

    /**
     * @throws JsonException
     */
    public function testConversationContinuesAfterReceivingNonConversationMessage(): void
    {
        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(EntrypointProcessor::class))->getFileName())
            ->include((new ReflectionClass(State1Processor::class))->getFileName())
            ->include((new ReflectionClass(State2Processor::class))->getFileName())
            ->include((new ReflectionClass(CommandProcessor::class))->getFileName());

        UpdateProvider::setInput(
            $this->getTextMessage(message: 'please start a conversation', createdAt: new DateTimeImmutable()),
        );

        $runner = self::getRunner(
            $configBuilder->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->addState(new State('state2', processors: [State2Processor::class]))
                    ->endState('end')
                    ->unprocessedStrategy(UnprocessedStrategy::ContinueProcessing)
                    ->build(),
            ],
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'start',
                'unprocessedStrategy' => UnprocessedStrategy::ContinueProcessing->value,
                'data'                => [],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getCallbackQuery(
                callbackQueryMessage: 'state1',
                originalMessageText: 'original text',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::ContinueProcessing->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );

        UpdateProvider::setInput(
            $this->getTextMessage(
                message: '/command',
                createdAt: new DateTimeImmutable(),
            ),
        );

        $runner->run();

        self::assertDirectoryExists($conversationsDirectory);
        self::assertFileExists($conversationFileDirectory);

        $conversationContent = json_decode(
            file_get_contents($conversationFileDirectory),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertEqualsCanonicalizing(
            [
                'conversation'        => 'test conversation',
                'state'               => 'state2',
                'unprocessedStrategy' => UnprocessedStrategy::ContinueProcessing->value,
                'data'                => [
                    State1Processor::class => 'test',
                ],
            ],
            $conversationContent,
        );
    }

    // public function testRunWithCustomUnsupportedProcessor(): void
    // {
    //
    // }
}
