<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use DateTimeImmutable;
use DateTimeZone;
use JsonException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Factory\FactoryInterface;
use Temkaa\Botifier\Factory\ResponseFactory;
use Temkaa\Botifier\Model\Response\DeleteWebhookResponse;
use Temkaa\Botifier\Model\Response\GetUpdatesResponse;
use Temkaa\Botifier\Model\Response\GetWebhookInfoResponse;
use Temkaa\Botifier\Model\Response\Nested\Chat;
use Temkaa\Botifier\Model\Response\Nested\Message;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\Response\Nested\WebhookInfo;
use Temkaa\Botifier\Model\Response\SendMessageResponse;
use Temkaa\Botifier\Model\Response\SetMyDescriptionResponse;
use Temkaa\Botifier\Model\Response\SetWebhookResponse;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Model\Shared\User;
use Temkaa\Container\Attribute\Bind\InstanceOfIterator;
use Temkaa\Container\Builder\Config\ClassBuilder;
use Temkaa\Container\Builder\ConfigBuilder;
use Temkaa\Container\Builder\ContainerBuilder;
use function dirname;
use function json_encode;

final class ResponseFactoryTest extends TestCase
{
    private static ResponseFactory $responseFactory;

    public static function getDataForCreateTest(): iterable
    {
        yield [
            ApiMethod::DeleteWebhook,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'webhook not set',
            ],
            new DeleteWebhookResponse(
                false,
                null,
                'webhook not set',
                400,
            ),
        ];
        yield [
            ApiMethod::DeleteWebhook,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new DeleteWebhookResponse(
                true,
                true,
                'description',
                null,
            ),
        ];

        yield [
            ApiMethod::SetMyDescription,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new SetMyDescriptionResponse(
                true,
                true,
                'description',
                null,
            ),
        ];
        yield [
            ApiMethod::SetMyDescription,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'description not set',
            ],
            new SetMyDescriptionResponse(
                false,
                null,
                'description not set',
                400,
            ),
        ];

        yield [
            ApiMethod::SetWebhook,
            [
                'ok'          => true,
                'result'      => true,
                'description' => 'description',
            ],
            new SetWebhookResponse(
                true,
                true,
                'description',
                null,
            ),
        ];
        yield [
            ApiMethod::SetWebhook,
            [
                'ok'          => false,
                'error_code'  => 400,
                'description' => 'webhook not set',
            ],
            new SetWebhookResponse(
                false,
                null,
                'webhook not set',
                400,
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
                null,
                'error sending message',
                400,
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
                new Message(
                    1234,
                    (new DateTimeImmutable())->setTimestamp(1633088562)->setTimezone(new DateTimeZone('UTC')),
                    chat: new Chat(1234, 'private', username: 'username', firstName: 'first_name'),
                    from: new User(
                        1234,
                        isBot: false,
                        firstName: 'first_name',
                        username: 'username',
                        languageCode: Language::Russian,
                    ),
                    text: 'message text',
                ),
                null,
                null,
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
                null,
                'error getting webhook info',
                400,
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
                ok: true,
                result: new WebhookInfo(
                    'someurl.com',
                    true,
                    0,
                    '192.168.200.6',
                    (new DateTimeImmutable())->setTimestamp(1633088562)->setTimezone(new DateTimeZone('UTC')),
                    'last_error_message',
                    maxConnections: 20,
                    allowedUpdates: [],
                ),
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
                ok: true,
                result: new WebhookInfo(
                    'someurl.com',
                    true,
                    0,
                ),
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
                null,
                'error getting updates',
                400,
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
                result: [
                    new Update(
                        updateId: 1,
                        message: new Message(
                            1234,
                            (new DateTimeImmutable())->setTimestamp(1633088562)->setTimezone(new DateTimeZone('UTC')),
                            chat: new Chat(1234, 'private', username: 'username', firstName: 'first_name'),
                            from: new User(
                                1234,
                                isBot: false,
                                firstName: 'first_name',
                                username: 'username',
                                languageCode: Language::Russian,
                            ),
                            text: 'message text',
                        ),
                    ),
                ],
            ),
        ];
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $config = ConfigBuilder::make()
            ->include(
                dirname(
                    (new ReflectionClass(ResponseFactory::class))->getFileName(),
                ),
            )
            ->configure(
                ClassBuilder::make(ResponseFactory::class)
                    ->bindVariable('$factories', new InstanceOfIterator(FactoryInterface::class))
                    ->build(),
            )
            ->build();

        $container = ContainerBuilder::make()
            ->add($config)
            ->build();

        self::$responseFactory = $container->get(ResponseFactory::class);
    }

    /**
     * @throws JsonException
     */
    #[DataProvider('getDataForCreateTest')]
    public function testCreate(ApiMethod $method, array $message, ResponseInterface $expectedResponse): void
    {
        $actualResponse = self::$responseFactory->create($method, json_encode($message, JSON_THROW_ON_ERROR));
        self::assertEquals($expectedResponse, $actualResponse);
    }
}
