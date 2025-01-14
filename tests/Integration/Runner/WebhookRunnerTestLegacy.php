<?php

declare(strict_types=1);

namespace Runner;

use DateTimeImmutable;
use JsonException;
use phpmock\Mock;
use phpmock\MockBuilder;
use phpmock\MockEnabledException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use Temkaa\Botifier\DependencyInjection\ConfigProvider as WebhookRunnerContainerConfigProvider;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Response\Nested\Chat;
use Temkaa\Botifier\Model\Response\Nested\Message;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\Shared\User;
use Temkaa\Botifier\WebhookRunner;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\DependencyInjection\ConfigProvider;
use Tests\Helper\Service\Handler\CallbackHandler;
use Tests\Helper\Service\Handler\CustomUnsupportedMessageHandler;
use Tests\Helper\Service\Logger;
use Tests\Integration\Runner\LegacyAbstractRunnerTestCase;
use function json_encode;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class WebhookRunnerTestLegacy extends LegacyAbstractRunnerTestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function testBootsWithContainer(): void
    {
        $container = ContainerBuilder::make()->add(new WebhookRunnerContainerConfigProvider())->build();

        self::assertInstanceOf(WebhookRunner::class, $container->get(WebhookRunner::class));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     */
    public function testRun(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock($this->getTextMessage('/start asd asd', createdAt: $now));
        $mock->enable();

        // todo: rename USER to FROM in models?
        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackHandler::setHandleCallback(function (Update $update) use ($now): void {
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

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $mock->disable();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function testRunWithCustomUnsupportedMessageHandler(): void
    {
        $container = ContainerBuilder::make()
            ->add(
                (new ConfigProvider())
                    ->getBuilder()
                    ->include(__DIR__.'/../../Helper/Service/Logger.php')
                    ->include(__DIR__.'/../../Helper/Service/Handler/CustomUnsupportedMessageHandler.php')
                    ->bindInterface(UnsupportedHandlerInterface::class, CustomUnsupportedMessageHandler::class)
                    ->build(),
            )
            ->build();

        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock($this->getTextMessage('/start asd asd', createdAt: $now));
        $mock->enable();

        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => false);

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $logger = $container->get(Logger::class);

        self::assertSame(
            ['warning' => ['This message type is unsupported']],
            $logger->getMessages(),
        );

        $mock->disable();
    }

    /**
     * @throws JsonException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     * @throws MockEnabledException
     */
    public function testRunWithDefaultUnsupportedMessageHandler(): void
    {
        $container = ContainerBuilder::make()
            ->add(
                (new ConfigProvider())
                    ->getBuilder()
                    ->include(__DIR__.'/../../Helper/Service/Logger.php')
                    ->build(),
            )
            ->build();

        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $message = $this->getTextMessage('/start asd asd', createdAt: $now);
        $mock = $this->getInputMock($message);
        $mock->enable();

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $logger = $container->get(Logger::class);

        self::assertSame(
            [
                'warning' => [
                    'Could not find suitable handler for update id "836780966".',
                ],
            ],
            $logger->getMessages(),
        );

        $mock->disable();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithEditedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $editedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock($this->getEditedTextMessage('non command message', $createdAt, $editedAt));
        $mock->enable();

        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackHandler::setHandleCallback(function (Update $update) use ($createdAt, $editedAt): void {
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

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $mock->disable();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithEditedRepliedMessage(): void
    {
        $replyToMessageCreatedAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $repliedUpdatedAt = (new DateTimeImmutable('-2 day'))->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock(
            $this->getEditedReplyTextMessage(
                repliedToMessage: 'replied to message',
                editedReplyMessage: 'edited reply message',
                repliedToMessageCreatedAt: $replyToMessageCreatedAt,
                editedReplyMessageCreatedAt: $repliedCreatedAt,
                editedReplyMessageUpdatedAt: $repliedUpdatedAt,
            ),
        );
        $mock->enable();

        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackHandler::setHandleCallback(
            function (Update $update) use ($replyToMessageCreatedAt, $repliedCreatedAt, $repliedUpdatedAt): void {
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

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $mock->disable();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithNonCommandTextMessage(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock($this->getTextMessage('non command message', createdAt: $now));
        $mock->enable();

        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackHandler::setHandleCallback(function (Update $update) use ($now): void {
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

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $mock->disable();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws MockEnabledException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithRepliedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $mock = $this->getInputMock(
            $this->getRepliedTextMessage(
                originalMessage: 'original message',
                replyMessage: 'reply message',
                originalMessageCreatedAt: $createdAt,
                replyMessageCreatedAt: $repliedCreatedAt,
            ),
        );
        $mock->enable();

        CallbackHandler::setSupportsCallback(static fn (Update $update): bool => true);
        CallbackHandler::setHandleCallback(function (Update $update) use ($createdAt, $repliedCreatedAt): void {
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
        });

        $runner = $this->getRunner(WebhookRunner::class);
        $runner->run();

        $mock->disable();
    }

    private function getInputMock(array $input): Mock
    {
        return (new MockBuilder())
            ->setNamespace('Temkaa\Botifier\Provider\Webhook')
            ->setName('file_get_contents')
            ->setFunction(static fn (): string => json_encode($input, JSON_THROW_ON_ERROR))
            ->build();
    }
}
