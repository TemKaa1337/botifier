<?php

declare(strict_types=1);

namespace Runner\PollingRunner;

use Composer\Autoload\ClassLoader;
use DateTimeImmutable;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use Temkaa\Botifier\Builder\ConversationBuilder;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\Conversation\UnprocessedStrategy;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\ResponseFactory;
use Temkaa\Botifier\Model\Config\Conversation\State;
use Temkaa\Botifier\Model\Response\Nested\Chat;
use Temkaa\Botifier\Model\Response\Nested\Message;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\Shared\User;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\Processor\CallbackProcessor;
use Tests\Helper\Processor\EntrypointProcessor;
use Tests\Helper\Processor\State1Processor;
use Tests\Helper\Processor\UnsupportedStatelessProcessor;
use Tests\Helper\Service\Client;
use Tests\Helper\Service\Logger;
use Tests\Helper\Trait\Mock\UpdateMockTrait;
use Tests\Integration\Runner\AbstractRunnerTestCase;
use function dirname;
use function file_get_contents;
use function json_decode;
use function json_encode;
use function md5;
use function sprintf;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class StatelessRunnerTest extends AbstractRunnerTestCase
{
    use UpdateMockTrait;

    private static ResponseFactory $responseFactory;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$responseFactory = ContainerBuilder::make()
            ->add(
                ConfigBuilder::make()
                    ->include(
                        dirname((new ReflectionClass(ResponseFactory::class))->getFileName()),
                    )
                    ->configure(
                        ClassBuilder::make(ResponseFactory::class)
                            ->bindVariable('$factories', new InstanceOfIterator(FactoryInterface::class))
                            ->build(),
                    )
                    ->build(),
            )
            ->build()
            ->get(ResponseFactory::class);
    }

    protected static function getRunnerClass(): string
    {
        return PollingRunner::class;
    }

    /**
     * @throws JsonException
     */
    public function testRunWithConversationEntrypoint(): void
    {
        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder->include((new ReflectionClass(EntrypointProcessor::class))->getFileName());

        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getTextMessage(
                                    message: 'please start a conversation',
                                    createdAt: new DateTimeImmutable(),
                                ),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $runner = self::getRunner(
            $configBuilder->build(),
            conversations: [
                (new ConversationBuilder())
                    ->name('test conversation')
                    ->entrypoint(EntrypointProcessor::class)
                    ->startState('start')
                    ->addState(new State('start', processors: [State1Processor::class]))
                    ->endState('end')
                    ->build(),
            ],
        );

        $runner->run();

        $conversationsDirectory = $this->getConversationFolder();
        $conversationFileDirectory = sprintf(
            '%s/%s.json',
            $conversationsDirectory,
            md5('772517840|123451222'),
        );

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
    }

    /**
     * @throws JsonException
     */
    public function testRunWithEditedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $editedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getEditedTextMessage('non command message', $createdAt, $editedAt),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackProcessor::setHandleCallback(static function (Update $update) use ($createdAt, $editedAt): void {
            $expectedUpdate = new Update(
                updateId: 836780966,
                editedMessage: new Message(
                    messageId: 1234567,
                    date: $createdAt,
                    chat: new Chat(
                        id: 772517840,
                        type: 'private',
                        username: 'username',
                        firstName: 'first_name',
                    ),
                    from: new User(
                        id: 123451222,
                        isBot: false,
                        firstName: 'first_name',
                        username: 'username',
                        languageCode: Language::Russian,
                    ),
                    editDate: $editedAt,
                    text: 'non command message',
                ),
            );

            self::assertEquals($expectedUpdate, $update);
        });

        $this->executeRunner();
    }

    /**
     * @throws JsonException
     */
    public function testRunWithEditedRepliedMessage(): void
    {
        $replyToMessageCreatedAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $repliedUpdatedAt = (new DateTimeImmutable('-2 day'))->setTime(0, 0, microsecond: 0);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getEditedReplyTextMessage(
                                    repliedToMessage: 'replied to message',
                                    editedReplyMessage: 'edited reply message',
                                    repliedToMessageCreatedAt: $replyToMessageCreatedAt,
                                    editedReplyMessageCreatedAt: $repliedCreatedAt,
                                    editedReplyMessageUpdatedAt: $repliedUpdatedAt,
                                ),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackProcessor::setHandleCallback(
            static function (Update $update) use (
                $replyToMessageCreatedAt,
                $repliedCreatedAt,
                $repliedUpdatedAt
            ): void {
                $expectedUpdate = new Update(
                    updateId: 836780966,
                    editedMessage: new Message(
                        messageId: 1234567,
                        date: $repliedCreatedAt,
                        chat: new Chat(
                            id: 772517840,
                            type: 'private',
                            username: 'username',
                            firstName: 'first_name',
                        ),
                        from: new User(
                            id: 123451222,
                            isBot: false,
                            firstName: 'first_name',
                            username: 'username',
                            languageCode: Language::Russian,
                        ),
                        replyToMessage: new Message(
                            messageId: 12345678,
                            date: $replyToMessageCreatedAt,
                            chat: new Chat(
                                id: 772517840,
                                type: 'private',
                                username: 'username',
                                firstName: 'first_name',
                            ),
                            from: new User(
                                id: 123451222,
                                isBot: false,
                                firstName: 'first_name',
                                username: 'username',
                                languageCode: Language::Russian,
                            ),
                            text: 'replied to message',
                        ),
                        editDate: $repliedUpdatedAt,
                        text: 'edited reply message',
                    ),
                );
                self::assertEquals($expectedUpdate, $update);
            },
        );

        $this->executeRunner();
    }

    /**
     * @throws JsonException
     */
    public function testRunWithLogger(): void
    {
        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(Logger::class))->getFileName());

        $runner = self::getRunner($configBuilder->build(), logger: Logger::class);

        CallbackProcessor::setSupportsCallback(static fn (Update $update): false => false);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getTextMessage('/start asd asd', createdAt: new DateTimeImmutable()),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $runner->run();

        self::assertSame(
            [
                'debug' => [
                    'Could not find suitable handler for update id "836780966".',
                ],
                'info'  => [
                    'Exiting from PollingRunner.',
                ],
            ],
            Logger::getMessages(),
        );
    }

    /**
     * @throws JsonException
     */
    public function testRunWithNonCommandTextMessage(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getTextMessage('non command message', createdAt: $now),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackProcessor::setHandleCallback(static function (Update $update) use ($now): void {
            $expectedUpdate = new Update(
                updateId: 836780966,
                message: new Message(
                    messageId: 1234567,
                    date: $now,
                    chat: new Chat(
                        id: 772517840,
                        type: 'private',
                        username: 'username',
                        firstName: 'first_name',
                    ),
                    from: new User(
                        id: 123451222,
                        isBot: false,
                        firstName: 'first_name',
                        username: 'username',
                        languageCode: Language::Russian,
                    ),
                    text: 'non command message',
                ),
            );

            self::assertEquals($expectedUpdate, $update);
        });

        $this->executeRunner();
    }

    /**
     * @throws JsonException
     */
    public function testRunWithRepliedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getRepliedTextMessage(
                                    originalMessage: 'original message',
                                    replyMessage: 'reply message',
                                    originalMessageCreatedAt: $createdAt,
                                    replyMessageCreatedAt: $repliedCreatedAt,
                                ),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackProcessor::setHandleCallback(
            static function (Update $update) use ($createdAt, $repliedCreatedAt): void {
                $expectedUpdate = new Update(
                    updateId: 836780966,
                    message: new Message(
                        messageId: 1234567,
                        date: $createdAt,
                        chat: new Chat(
                            id: 772517840,
                            type: 'private',
                            username: 'username',
                            firstName: 'first_name',
                        ),
                        from: new User(
                            id: 123451222,
                            isBot: false,
                            firstName: 'first_name',
                            username: 'username',
                            languageCode: Language::Russian,
                        ),
                        replyToMessage: new Message(
                            messageId: 12345678,
                            date: $repliedCreatedAt,
                            chat: new Chat(
                                id: 772517840,
                                type: 'private',
                                username: 'username',
                                firstName: 'first_name',
                            ),
                            from: new User(
                                id: 123451222,
                                isBot: false,
                                firstName: 'first_name',
                                username: 'username',
                                languageCode: Language::Russian,
                            ),
                            text: 'reply message',
                        ),
                        text: 'original message',
                    ),
                );
                self::assertEquals($expectedUpdate, $update);
            },
        );

        $this->executeRunner();
    }

    /**
     * @throws JsonException
     */
    public function testRunWithTextMessage(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getTextMessage('/start asd asd', createdAt: $now),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackProcessor::setHandleCallback(static function (Update $update) use ($now): void {
            $expectedUpdate = new Update(
                updateId: 836780966,
                message: new Message(
                    messageId: 1234567,
                    date: $now,
                    chat: new Chat(
                        id: 772517840,
                        type: 'private',
                        username: 'username',
                        firstName: 'first_name',
                    ),
                    from: new User(
                        id: 123451222,
                        isBot: false,
                        firstName: 'first_name',
                        username: 'username',
                        languageCode: Language::Russian,
                    ),
                    text: '/start asd asd',
                ),
            );

            self::assertEquals($expectedUpdate, $update);
        });

        $this->executeRunner();
    }

    /**
     * @throws JsonException
     */
    public function testRunWithUnsupportedStatelessProcessor(): void
    {
        $configBuilder = self::getDefaultContainerConfigBuilder();
        $configBuilder
            ->include((new ReflectionClass(Logger::class))->getFileName())
            ->include((new ReflectionClass(UnsupportedStatelessProcessor::class))->getFileName());

        $runner = self::getRunner(
            $configBuilder->build(),
            logger: Logger::class,
            unsupportedStatelessProcessor: UnsupportedStatelessProcessor::class,
        );

        CallbackProcessor::setSupportsCallback(static fn (Update $update): false => false);
        Client::setResponses(
            [
                self::$responseFactory->create(
                    ApiMethod::GetUpdates,
                    json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                $this->getTextMessage('/start asd asd', createdAt: new DateTimeImmutable()),
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $runner->run();

        self::assertSame(
            [
                'warning' => [
                    'something went wrong',
                ],
                'info'    => [
                    'Exiting from PollingRunner.',
                ],
            ],
            Logger::getMessages(),
        );
    }
}
