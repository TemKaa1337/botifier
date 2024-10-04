<?php

declare(strict_types=1);

namespace Tests\Integration\Runner;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Temkaa\Botifier\RunnerInterface;
use Temkaa\Container\Builder\ContainerBuilder;
use Tests\Helper\DependencyInjection\ConfigProvider;
use Tests\Helper\Service\Handler\CallbackHandler;

abstract class AbstractRunnerTestCase extends TestCase
{
    protected ContainerInterface $container;

    protected function getEditedReplyTextMessage(
        string $repliedToMessage,
        string $editedReplyMessage,
        DateTimeImmutable $repliedToMessageCreatedAt,
        DateTimeImmutable $editedReplyMessageCreatedAt,
        DateTimeImmutable $editedReplyMessageUpdatedAt,
    ): array {
        return [
            'update_id'      => 836780966,
            'edited_message' => [
                'message_id'       => 1234567,
                'from'             => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'             => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'             => $editedReplyMessageCreatedAt->getTimestamp(),
                'edit_date'        => $editedReplyMessageUpdatedAt->getTimestamp(),
                'reply_to_message' => [
                    'message_id' => 12345678,
                    'from'       => [
                        'id'            => 123451222,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 772517840,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => $repliedToMessageCreatedAt->getTimestamp(),
                    'text'       => $repliedToMessage,
                ],
                'text'             => $editedReplyMessage,
            ],
        ];
    }

    protected function getEditedTextMessage(
        string $message,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $editedAt,
    ): array {
        return [
            'update_id'      => 836780966,
            'edited_message' => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'edit_date'  => $editedAt->getTimestamp(),
                'text'       => $message,
            ],
        ];
    }

    protected function getRepliedTextMessage(
        string $originalMessage,
        string $replyMessage,
        DateTimeImmutable $originalMessageCreatedAt,
        DateTimeImmutable $replyMessageCreatedAt,
    ): array {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id'       => 1234567,
                'from'             => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'             => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'             => $originalMessageCreatedAt->getTimestamp(),
                'reply_to_message' => [
                    'message_id' => 12345678,
                    'from'       => [
                        'id'            => 123451222,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 772517840,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => $replyMessageCreatedAt->getTimestamp(),
                    'text'       => $replyMessage,
                ],
                'text'             => $originalMessage,
            ],
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getRunner(string $runner): RunnerInterface
    {
        return $this->container->get($runner);
    }

    protected function getStickerMessage(DateTimeImmutable $createdAt): array
    {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'sticker'    => [
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
            ],
        ];
    }

    protected function getTextMessage(string $message, DateTimeImmutable $createdAt): array
    {
        return [
            'update_id' => 836780966,
            'message'   => [
                'message_id' => 1234567,
                'from'       => [
                    'id'            => 123451222,
                    'is_bot'        => false,
                    'first_name'    => 'first_name',
                    'username'      => 'username',
                    'language_code' => 'ru',
                ],
                'chat'       => [
                    'id'         => 772517840,
                    'first_name' => 'first_name',
                    'username'   => 'username',
                    'type'       => 'private',
                ],
                'date'       => $createdAt->getTimestamp(),
                'text'       => $message,
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = ContainerBuilder::make()->add(new ConfigProvider())->build();

        CallbackHandler::reset();
    }
}
