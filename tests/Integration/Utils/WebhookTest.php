<?php

declare(strict_types=1);

namespace Tests\Integration\Utils;

use DateTimeImmutable;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Exception\Webhook\InvalidCertificateException;
use Temkaa\Botifier\Http\Client;
use Temkaa\Botifier\Model\Api\Webhook as WebhookModel;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Serializer\Action\WebhookInfoSerializer;
use Temkaa\Botifier\Serializer\Serializer;
use Temkaa\Botifier\Utils\Webhook;
use Tests\Helper\Service\Http\GuzzleHttpClient;

// TODO: think about introducing http codes everywhere as enums
final class WebhookTest extends TestCase
{
    private readonly GuzzleHttpClient $client;

    private readonly Webhook $webhook;

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetWebhookInfoWhenHookIsNotSet(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                'url'                    => 'some_url',
                                'has_custom_certificate' => true,
                                'pending_update_count'   => 10,
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->getInfo();

        self::assertTrue($response->success());
        self::assertNull($response->getDescription());
        self::assertNull($response->getErrorCode());

        $result = $response->getResult();
        self::assertInstanceOf(WebhookModel::class, $result);
        self::assertEquals('some_url', $result->getUrl());
        self::assertTrue($result->hasCustomCertificate());
        self::assertEquals(10, $result->getPendingUpdatesCount());
        self::assertNull($result->getIp());
        self::assertNull($result->getLastErrorDateTime());
        self::assertNull($result->getLastErrorMessage());
        self::assertNull($result->getMaxConnections());
        self::assertNull($result->getAllowedUpdates());
        self::assertNull($result->getAllowedUpdates());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetWebhookInfoWhenHookIsSet(): void
    {
        $now = (new DateTimeImmutable())->setTime(0, 0, microsecond: 0);
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'     => true,
                            'result' => [
                                'url'                    => 'some_url',
                                'has_custom_certificate' => true,
                                'pending_update_count'   => 10,
                                'ip_address'             => '192.168.200.6',
                                'last_error_date'        => $now->getTimestamp(),
                                'last_error_message'     => 'error message',
                                'max_connections'        => 10,
                                'allowed_updates'        => [],
                            ],
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->getInfo();

        self::assertTrue($response->success());
        self::assertNull($response->getDescription());
        self::assertNull($response->getErrorCode());

        $result = $response->getResult();
        self::assertInstanceOf(WebhookModel::class, $result);
        self::assertEquals('some_url', $result->getUrl());
        self::assertTrue($result->hasCustomCertificate());
        self::assertEquals(10, $result->getPendingUpdatesCount());
        self::assertEquals('192.168.200.6', $result->getIp());
        self::assertEquals($now, $result->getLastErrorDateTime());
        self::assertEquals('error message', $result->getLastErrorMessage());
        self::assertEquals(10, $result->getMaxConnections());
        self::assertIsArray($result->getAllowedUpdates());
        self::assertEmpty($result->getAllowedUpdates());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetWebhookInfoWithUnsuccessfulResponse(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'          => false,
                            'error_code'  => 400,
                            'description' => 'cannot get webhook info',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->getInfo();

        self::assertFalse($response->success());
        self::assertEquals('cannot get webhook info', $response->getDescription());
        self::assertEquals(400, $response->getErrorCode());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSet(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'          => true,
                            'result'      => true,
                            'description' => 'webhook set',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->set('some_url');

        self::assertTrue($response->success());
        self::assertTrue($response->getResult());
        self::assertEquals('webhook set', $response->getDescription());
        self::assertNull($response->getErrorCode());
    }

    /**
     * @throws GuzzleException
     */
    public function testSetWithNonExistingCertificateFile(): void
    {
        $path = 'non_existing_path';

        $this->expectException(InvalidCertificateException::class);
        $this->expectExceptionMessage(
            sprintf('Could not read certificate from file "%s".', $path),
        );

        $this->webhook->set('some_url', certificatePath: $path);
    }

    /**
     * @throws GuzzleException
     */
    public function testSetWithNonPubFile(): void
    {
        $path = __DIR__.'/../../Fixture/File/text_file.txt';

        $this->expectException(InvalidCertificateException::class);
        $this->expectExceptionMessage(
            'Could not read certificate from file "text_file.txt" with non "pub" extension.',
        );

        $this->webhook->set('some_url', certificatePath: $path);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSetWithUnsuccessfulResponse(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'          => false,
                            'error_code'  => 400,
                            'description' => 'webhook not set',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->set('some_url');

        self::assertFalse($response->success());
        self::assertNull($response->getResult());
        self::assertEquals('webhook not set', $response->getDescription());
        self::assertEquals(400, $response->getErrorCode());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testUnset(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'          => true,
                            'result'      => true,
                            'description' => 'webhook unset',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->unset();

        self::assertTrue($response->success());
        self::assertTrue($response->getResult());
        self::assertEquals('webhook unset', $response->getDescription());
        self::assertNull($response->getErrorCode());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testUnsetWithUnsuccessfulResponse(): void
    {
        $this->client->setResponses(
            [
                new Response(
                    body: json_encode(
                        [
                            'ok'          => false,
                            'error_code'  => 400,
                            'description' => 'webhook not unset',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->webhook->unset();

        self::assertFalse($response->success());
        self::assertNull($response->getResult());
        self::assertEquals('webhook not unset', $response->getDescription());
        self::assertEquals(400, $response->getErrorCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new GuzzleHttpClient();
        $this->webhook = new Webhook(
            new Bot('test_token'),
            new Client(
                $this->client,
                new Serializer(
                    [new WebhookInfoSerializer()],
                ),
            ),
        );

        $this->client->reset();
    }
}
