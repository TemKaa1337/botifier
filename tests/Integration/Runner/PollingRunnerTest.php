<?php

declare(strict_types=1);

namespace Runner;

use DateTimeImmutable;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use Temkaa\Botifier\DependencyInjection\ConfigProvider as PollingRunnerContainerConfigProvider;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Handler\UnsupportedHandlerInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\Response\Message\Content\Command;
use Temkaa\Botifier\Model\Response\Message\Content\Text;
use Temkaa\Botifier\Model\Response\Message\Content\UnknownContent;
use Temkaa\Botifier\PollingRunner;
use Temkaa\Botifier\Serializer\SerializerInterface;
use Temkaa\Botifier\Service\TelegramClientInterface;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\DependencyInjection\ConfigProvider;
use Tests\Helper\Service\Handler\CallbackHandler;
use Tests\Helper\Service\Handler\CustomUnsupportedMessageHandler;
use Tests\Helper\Service\Logger;
use Tests\Helper\Service\TelegramClient;
use Tests\Integration\Runner\AbstractRunnerTestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class PollingRunnerTest extends AbstractRunnerTestCase
{
    public function testBootsWithContainer(): void
    {
        $container = ContainerBuilder::make()->add(new PollingRunnerContainerConfigProvider())->build();
        $runner = $container->get(PollingRunner::class);
        self::assertInstanceOf(PollingRunner::class, $runner);
    }

    /**
     * @throws JsonException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRun(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $message = $this->getTextMessage('/start asd asd', createdAt: $now);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        // todo: rename USER to FROM in models?
        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(function (Message $message) use ($now): void {
            self::assertSame(1234567, $message->getId());
            self::assertSame(836780966, $message->getUpdateId());
            self::assertFalse($message->isEdit());
            self::assertFalse($message->isReply());
            self::assertNull($message->getRepliedTo());
            self::assertNull($message->getEditedAt());
            self::assertEquals($now, $message->getCreatedAt());

            $user = $message->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $message->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $message->getContent();
            self::assertInstanceOf(Command::class, $content);

            /** @var Command $content */
            self::assertSame('start', $content->getSignature());
            self::assertSame('asd asd', $content->getParameters());
            self::assertSame(Type::Command, $content->getType());
        });

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function testRunWithCustomUnsupportedMessageHandler(): void
    {
        $this->container = ContainerBuilder::make()
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
        $message = $this->getTextMessage('/start asd asd', createdAt: $now);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => false);

        $this->getRunner(PollingRunner::class)->run();

        $logger = $this->container->get(Logger::class);

        self::assertEqualsCanonicalizing(
            ['warning' => ['This message type is unsupported'], 'info' => ['Exiting from PollingRunner.']],
            $logger->getMessages(),
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function testRunWithDefaultUnsupportedMessageHandler(): void
    {
        $this->container = ContainerBuilder::make()
            ->add(
                (new ConfigProvider())
                    ->getBuilder()
                    ->include(__DIR__.'/../../Helper/Service/Logger.php')
                    ->build(),
            )
            ->build();

        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $message = $this->getTextMessage('/start asd asd', createdAt: $now);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();

        $logger = $this->container->get(Logger::class);

        self::assertSame(
            [
                'warning' => [
                    sprintf(
                        'Could not find suitable handler for message "%s".',
                        json_encode($message['result'][0], JSON_THROW_ON_ERROR),
                    ),
                ],
                'info' => ['Exiting from PollingRunner.']
            ],
            $logger->getMessages(),
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithEditedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $editedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $message = $this->getEditedTextMessage('non command message', $createdAt, $editedAt);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(function (Message $message) use ($createdAt, $editedAt): void {
            self::assertSame(1234567, $message->getId());
            self::assertSame(836780966, $message->getUpdateId());
            self::assertTrue($message->isEdit());
            self::assertFalse($message->isReply());
            self::assertNull($message->getRepliedTo());
            self::assertEquals($editedAt, $message->getEditedAt());
            self::assertEquals($createdAt, $message->getCreatedAt());

            $user = $message->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $message->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $message->getContent();
            self::assertInstanceOf(Text::class, $content);

            /** @var Text $content */
            self::assertSame('non command message', $content->getText());
            self::assertSame(Type::Text, $content->getType());
        });

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithEditedRepliedMessage(): void
    {
        $replyToMessageCreatedAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $repliedUpdatedAt = (new DateTimeImmutable('-2 day'))->setTime(0, 0, microsecond: 0);
        $message = $this->getEditedReplyTextMessage(
            repliedToMessage: 'replied to message',
            editedReplyMessage: 'edited reply message',
            repliedToMessageCreatedAt: $replyToMessageCreatedAt,
            editedReplyMessageCreatedAt: $repliedCreatedAt,
            editedReplyMessageUpdatedAt: $repliedUpdatedAt,
        );
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(
            function (Message $message) use ($replyToMessageCreatedAt, $repliedCreatedAt, $repliedUpdatedAt): void {
                $repliedToMessage = $message->getRepliedTo();
                self::assertSame(1234567, $message->getId());
                self::assertSame(836780966, $message->getUpdateId());
                self::assertTrue($message->isEdit());
                self::assertTrue($message->isReply());
                self::assertInstanceOf(Message::class, $repliedToMessage);
                self::assertEquals($repliedUpdatedAt, $message->getEditedAt());
                self::assertEquals($repliedCreatedAt, $message->getCreatedAt());

                $user = $message->getUser();
                self::assertSame(123451222, $user->getId());
                self::assertFalse($user->isBot());
                self::assertSame('first_name', $user->getFirstName());
                self::assertSame('username', $user->getUsername());
                self::assertSame(Language::Russian, $user->getLanguage());

                $chat = $message->getChat();
                self::assertSame(772517840, $chat->getId());
                self::assertSame('first_name', $chat->getFirstName());
                self::assertSame('username', $chat->getUsername());
                self::assertSame('private', $chat->getType());

                $content = $message->getContent();
                self::assertInstanceOf(Text::class, $content);

                /** @var Text $content */
                self::assertSame('edited reply message', $content->getText());
                self::assertSame(Type::Text, $content->getType());

                self::assertSame(12345678, $repliedToMessage->getId());
                self::assertNull($repliedToMessage->getUpdateId());
                self::assertFalse($repliedToMessage->isEdit());
                self::assertFalse($repliedToMessage->isReply());
                self::assertNull($repliedToMessage->getEditedAt());
                self::assertEquals($replyToMessageCreatedAt, $repliedToMessage->getCreatedAt());

                $user = $repliedToMessage->getUser();
                self::assertSame(123451222, $user->getId());
                self::assertFalse($user->isBot());
                self::assertSame('first_name', $user->getFirstName());
                self::assertSame('username', $user->getUsername());
                self::assertSame(Language::Russian, $user->getLanguage());

                $chat = $repliedToMessage->getChat();
                self::assertSame(772517840, $chat->getId());
                self::assertSame('first_name', $chat->getFirstName());
                self::assertSame('username', $chat->getUsername());
                self::assertSame('private', $chat->getType());

                $content = $repliedToMessage->getContent();
                self::assertInstanceOf(Text::class, $content);

                /** @var Text $content */
                self::assertSame('replied to message', $content->getText());
                self::assertSame(Type::Text, $content->getType());
            },
        );

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithNonCommandTextMessage(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $message = $this->getTextMessage('non command message', createdAt: $now);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(function (Message $message) use ($now): void {
            self::assertSame(1234567, $message->getId());
            self::assertSame(836780966, $message->getUpdateId());
            self::assertFalse($message->isEdit());
            self::assertFalse($message->isReply());
            self::assertNull($message->getRepliedTo());
            self::assertNull($message->getEditedAt());
            self::assertEquals($now, $message->getCreatedAt());

            $user = $message->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $message->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $message->getContent();
            self::assertInstanceOf(Text::class, $content);

            /** @var Text $content */
            self::assertSame('non command message', $content->getText());
            self::assertSame(Type::Text, $content->getType());
        });

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithRepliedMessage(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $repliedCreatedAt = (new DateTimeImmutable('-1 day'))->setTime(0, 0, microsecond: 0);
        $message = $this->getRepliedTextMessage(
            originalMessage: 'original message',
            replyMessage: 'reply message',
            originalMessageCreatedAt: $createdAt,
            replyMessageCreatedAt: $repliedCreatedAt,
        );
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(function (Message $message) use ($createdAt, $repliedCreatedAt): void {
            $repliedToMessage = $message->getRepliedTo();
            self::assertSame(1234567, $message->getId());
            self::assertSame(836780966, $message->getUpdateId());
            self::assertFalse($message->isEdit());
            self::assertTrue($message->isReply());
            self::assertInstanceOf(Message::class, $repliedToMessage);
            self::assertNull($message->getEditedAt());
            self::assertEquals($createdAt, $message->getCreatedAt());

            $user = $message->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $message->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $message->getContent();
            self::assertInstanceOf(Text::class, $content);

            /** @var Text $content */
            self::assertSame('original message', $content->getText());
            self::assertSame(Type::Text, $content->getType());

            self::assertSame(12345678, $repliedToMessage->getId());
            self::assertNull($repliedToMessage->getUpdateId());
            self::assertFalse($repliedToMessage->isEdit());
            self::assertFalse($repliedToMessage->isReply());
            self::assertNull($repliedToMessage->getRepliedTo());
            self::assertNull($repliedToMessage->getEditedAt());
            self::assertEquals($repliedCreatedAt, $repliedToMessage->getCreatedAt());

            $user = $repliedToMessage->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $repliedToMessage->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $repliedToMessage->getContent();
            self::assertInstanceOf(Text::class, $content);

            /** @var Text $content */
            self::assertSame('reply message', $content->getText());
            self::assertSame(Type::Text, $content->getType());
        });

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     */
    public function testRunWithUnknownMessageContentType(): void
    {
        $createdAt = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $message = $this->getStickerMessage($createdAt);
        $message = [
            'ok'     => true,
            'result' => [$message],
        ];

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        /** @var TelegramClient $telegramClient */
        $telegramClient = $this->container->get(TelegramClientInterface::class);
        $telegramClient->setResponses(
            [
                $serializer->deserialize(ApiMethod::GetUpdates, json_encode($message, JSON_THROW_ON_ERROR)),
            ],
        );

        CallbackHandler::setSupportsCallback(static fn (Message $message): bool => true);
        CallbackHandler::setHandleCallback(function (Message $message) use ($createdAt): void {
            self::assertSame(1234567, $message->getId());
            self::assertSame(836780966, $message->getUpdateId());
            self::assertFalse($message->isEdit());
            self::assertFalse($message->isReply());
            self::assertNull($message->getRepliedTo());
            self::assertNull($message->getEditedAt());
            self::assertEquals($createdAt, $message->getCreatedAt());

            $user = $message->getUser();
            self::assertSame(123451222, $user->getId());
            self::assertFalse($user->isBot());
            self::assertSame('first_name', $user->getFirstName());
            self::assertSame('username', $user->getUsername());
            self::assertSame(Language::Russian, $user->getLanguage());

            $chat = $message->getChat();
            self::assertSame(772517840, $chat->getId());
            self::assertSame('first_name', $chat->getFirstName());
            self::assertSame('username', $chat->getUsername());
            self::assertSame('private', $chat->getType());

            $content = $message->getContent();
            self::assertInstanceOf(UnknownContent::class, $content);

            /** @var UnknownContent $content */
            self::assertSame(
                [
                    'width'          => 512,
                    'height'         => 512,
                    'emoji'          => '\ud83e\udd7a',
                    'set_name'       => 'Barbiturato',
                    'is_animated'    => false,
                    'is_video'       => false,
                    'type'           => 'regular',
                    'thumbnail'      => [
                        'file_id'        => 'AAMCAgADGQEAAy1m-UGDBm2AlDMv2l-JT4a_u_AGTAACxAADmlyrHXTaQf0e-7R3AQAHbQADNgQ',
                        'file_unique_id' => 'AQADxAADmlyrHXI',
                        'file_size'      => 9306,
                        'width'          => 320,
                        'height'         => 320,
                    ],
                    'thumb'          => [
                        'file_id'        => 'AAMCAgADGQEAAy1m-UGDBm2AlDMv2l-JT4a_u_AGTAACxAADmlyrHXTaQf0e-7R3AQAHbQADNgQ',
                        'file_unique_id' => 'AQADxAADmlyrHXI',
                        'file_size'      => 9306,
                        'width'          => 320,
                        'height'         => 320,
                    ],
                    'file_id'        => 'CAACAgIAAxkBAAMtZvlBgwZtgJQzL9pfiU-Gv7vwBkwAAsQAA5pcqx102kH9Hvu0dzYE',
                    'file_unique_id' => 'AgADxAADmlyrHQ',
                    'file_size'      => 17354,
                ],
                $content->getMessage(),
            );
            self::assertSame(Type::Unknown, $content->getType());
            self::assertSame('sticker', $content->getKey());
        });

        $runner = $this->getRunner(PollingRunner::class);
        $runner->run();
    }
}
