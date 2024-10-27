<?php

declare(strict_types=1);

namespace Tests\Unit\Serializer;

use DateTimeImmutable;
use JsonException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\DependencyInjection\Command\ConfigProvider;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Response\GeneralResponse;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;
use Temkaa\Botifier\Model\Response\GetWebhookInfoResponse;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\Response\SendMessageResponse;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Serializer\SerializerInterface;
use Temkaa\Container\Builder\ContainerBuilder;

final class SerializerTest extends TestCase
{
    private readonly SerializerInterface $serializer;

    /**
     * @throws JsonException
     */
    public static function getDataForSerializerTest(): iterable
    {
        yield [
            ApiMethod::DeleteDescription,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new GeneralResponse(
                true,
                'description',
                null,
                true,
                [
                    'ok'          => true,
                    'result'      => true,
                    'description' => 'description',
                ],
            ),
        ];
        yield [
            ApiMethod::DeleteDescription,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'description not deleted',
            ],
            new GeneralResponse(
                false,
                'description not deleted',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'description not deleted',
                ],
            ),
        ];

        yield [
            ApiMethod::DeleteWebhook,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'webhook not set',
            ],
            new GeneralResponse(
                false,
                'webhook not set',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'webhook not set',
                ],
            ),
        ];
        yield [
            ApiMethod::DeleteWebhook,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new GeneralResponse(
                true,
                'description',
                null,
                true,
                [
                    'ok'          => true,
                    'result'      => true,
                    'description' => 'description',
                ],
            ),
        ];

        yield [
            ApiMethod::SetDescription,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new GeneralResponse(
                true,
                'description',
                null,
                true,
                [
                    'ok'          => true,
                    'result'      => true,
                    'description' => 'description',
                ],
            ),
        ];
        yield [
            ApiMethod::SetDescription,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'description not set',
            ],
            new GeneralResponse(
                false,
                'description not set',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'description not set',
                ],
            ),
        ];

        yield [
            ApiMethod::SetWebhook,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new GeneralResponse(
                true,
                'description',
                null,
                true,
                [
                    'ok'          => true,
                    'result'      => true,
                    'description' => 'description',
                ],
            ),
        ];
        yield [
            ApiMethod::SetWebhook,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'webhook not set',
            ],
            new GeneralResponse(
                false,
                'webhook not set',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'webhook not set',
                ],
            ),
        ];

        yield [
            ApiMethod::SendMessage,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'error sending message',
            ],
            new SendMessageResponse(
                false,
                'error sending message',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'error sending message',
                ],
            ),
        ];
        yield [
            ApiMethod::SendMessage,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'error sending message',
                'result'      => false,
            ],
            new SendMessageResponse(
                false,
                'error sending message',
                400,
                false,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'error sending message',
                    'result'      => false,
                ],
            ),
        ];
        yield [
            ApiMethod::SendMessage,
            [
                'ok'     => true,
                'result' => [
                    'message_id' => 1234,
                    'from'       => [
                        'id'            => 1234,
                        'is_bot'        => false,
                        'first_name'    => 'first_name',
                        'username'      => 'username',
                        'language_code' => 'ru',
                    ],
                    'chat'       => [
                        'id'         => 1234,
                        'first_name' => 'first_name',
                        'username'   => 'username',
                        'type'       => 'private',
                    ],
                    'date'       => 1633088562,
                    'text'       => 'message text',
                ],
            ],
            new SendMessageResponse(
                true,
                null,
                null,
                new Message(
                    1234,
                    new Message\User(1234, 'username', 'first_name', false, Language::Russian),
                    new Message\Chat(1234, 'username', 'first_name', 'private'),
                    new Message\Content\Text('message text', Type::Text),
                    null,
                    (new DateTimeImmutable())->setTimestamp(1633088562),
                    null,
                    false,
                    false,
                    null,
                    json_encode(
                        [
                            'message_id' => 1234,
                            'from'       => [
                                'id'            => 1234,
                                'is_bot'        => false,
                                'first_name'    => 'first_name',
                                'username'      => 'username',
                                'language_code' => 'ru',
                            ],
                            'chat'       => [
                                'id'         => 1234,
                                'first_name' => 'first_name',
                                'username'   => 'username',
                                'type'       => 'private',
                            ],
                            'date'       => 1633088562,
                            'text'       => 'message text',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
                [
                    'ok'     => true,
                    'result' => [
                        'message_id' => 1234,
                        'from'       => [
                            'id'            => 1234,
                            'is_bot'        => false,
                            'first_name'    => 'first_name',
                            'username'      => 'username',
                            'language_code' => 'ru',
                        ],
                        'chat'       => [
                            'id'         => 1234,
                            'first_name' => 'first_name',
                            'username'   => 'username',
                            'type'       => 'private',
                        ],
                        'date'       => 1633088562,
                        'text'       => 'message text',
                    ],
                ],
            ),
        ];

        yield [
            ApiMethod::GetWebhookInfo,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'error getting webhook info',
            ],
            new GetWebhookInfoResponse(
                false,
                'error getting webhook info',
                400,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'error getting webhook info',
                ],
            ),
        ];
        yield [
            ApiMethod::GetWebhookInfo,
            [
                'ok'     => true,
                'result' => [
                    'url'                    => 'someurl.com',
                    'has_custom_certificate' => true,
                    'pending_update_count'   => 0,
                    'ip_address'             => '192.168.200.6',
                    'last_error_date'        => 1633088562,
                    'last_error_message'     => 'last_error_message',
                    'max_connections'        => 20,
                    'allowed_updates'        => [],
                ],
            ],
            new GetWebhookInfoResponse(
                success: true,
                description: null,
                errorCode: null,
                url: 'someurl.com',
                hasCustomCertificate: true,
                pendingUpdatesCount: 0,
                ip: '192.168.200.6',
                lastErrorDateTime: (new DateTimeImmutable())->setTimestamp(1633088562),
                lastErrorMessage: 'last_error_message',
                maxConnections: 20,
                allowedUpdates: [],
                raw: [
                    'ok'     => true,
                    'result' => [
                        'url'                    => 'someurl.com',
                        'has_custom_certificate' => true,
                        'pending_update_count'   => 0,
                        'ip_address'             => '192.168.200.6',
                        'last_error_date'        => 1633088562,
                        'last_error_message'     => 'last_error_message',
                        'max_connections'        => 20,
                        'allowed_updates'        => [],
                    ],
                ],
            ),
        ];
        yield [
            ApiMethod::GetWebhookInfo,
            [
                'ok'     => true,
                'result' => [
                    'url'                    => 'someurl.com',
                    'has_custom_certificate' => true,
                    'pending_update_count'   => 0,
                ],
            ],
            new GetWebhookInfoResponse(
                success: true,
                description: null,
                errorCode: null,
                url: 'someurl.com',
                hasCustomCertificate: true,
                pendingUpdatesCount: 0,
                ip: null,
                lastErrorDateTime: null,
                lastErrorMessage: null,
                maxConnections: null,
                allowedUpdates: null,
                raw: [
                    'ok'     => true,
                    'result' => [
                        'url'                    => 'someurl.com',
                        'has_custom_certificate' => true,
                        'pending_update_count'   => 0,
                    ],
                ],
            ),
        ];

        yield [
            ApiMethod::GetUpdates,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'error getting updates',
            ],
            new GetUpdatesResponse(
                false,
                'error getting updates',
                400,
                null,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'error getting updates',
                ],
            ),
        ];
        yield [
            ApiMethod::GetUpdates,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'error getting updates',
                'result'      => false,
            ],
            new GetUpdatesResponse(
                false,
                'error getting updates',
                400,
                false,
                [
                    'ok'          => false,
                    'error_code'  => 400,
                    'description' => 'error getting updates',
                    'result'      => false,
                ],
            ),
        ];
        yield [
            ApiMethod::GetUpdates,
            [
                'ok'     => true,
                'result' => [
                    [
                        'update_id' => 1,
                        'message'   => [
                            'message_id' => 1234,
                            'from'       => [
                                'id'            => 1234,
                                'is_bot'        => false,
                                'first_name'    => 'first_name',
                                'username'      => 'username',
                                'language_code' => 'ru',
                            ],
                            'chat'       => [
                                'id'         => 1234,
                                'first_name' => 'first_name',
                                'username'   => 'username',
                                'type'       => 'private',
                            ],
                            'date'       => 1633088562,
                            'text'       => 'message text',
                        ],
                    ],
                ],
            ],
            new GetUpdatesResponse(
                true,
                null,
                null,
                [
                    new Message(
                        1234,
                        new Message\User(1234, 'username', 'first_name', false, Language::Russian),
                        new Message\Chat(1234, 'username', 'first_name', 'private'),
                        new Message\Content\Text('message text', Type::Text),
                        1,
                        (new DateTimeImmutable())->setTimestamp(1633088562),
                        null,
                        false,
                        false,
                        null,
                        json_encode(
                            [
                                'update_id' => 1,
                                'message'   => [
                                    'message_id' => 1234,
                                    'from'       => [
                                        'id'            => 1234,
                                        'is_bot'        => false,
                                        'first_name'    => 'first_name',
                                        'username'      => 'username',
                                        'language_code' => 'ru',
                                    ],
                                    'chat'       => [
                                        'id'         => 1234,
                                        'first_name' => 'first_name',
                                        'username'   => 'username',
                                        'type'       => 'private',
                                    ],
                                    'date'       => 1633088562,
                                    'text'       => 'message text',
                                ],
                            ],
                            JSON_THROW_ON_ERROR,
                        ),
                    ),
                ],
                [
                    'ok'     => true,
                    'result' => [
                        [
                            'update_id' => 1,
                            'message'   => [
                                'message_id' => 1234,
                                'from'       => [
                                    'id'            => 1234,
                                    'is_bot'        => false,
                                    'first_name'    => 'first_name',
                                    'username'      => 'username',
                                    'language_code' => 'ru',
                                ],
                                'chat'       => [
                                    'id'         => 1234,
                                    'first_name' => 'first_name',
                                    'username'   => 'username',
                                    'type'       => 'private',
                                ],
                                'date'       => 1633088562,
                                'text'       => 'message text',
                            ],
                        ],
                    ],
                ],
            ),
        ];
    }

    /**
     * @throws JsonException
     */
    #[DataProvider('getDataForSerializerTest')]
    public function testDeserialize(ApiMethod $method, array $message, ResponseInterface $expectedResponse): void
    {
        $actualResponse = $this->serializer->deserialize($method, json_encode($message, JSON_THROW_ON_ERROR));
        self::assertEquals($expectedResponse, $actualResponse);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $container = ContainerBuilder::make()->add(new ConfigProvider())->build();

        $this->serializer = $container->get(SerializerInterface::class);
    }
}
