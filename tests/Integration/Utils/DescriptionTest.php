<?php

declare(strict_types=1);

namespace Tests\Integration\Utils;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonException;
use PHPUnit\Framework\TestCase;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Http\Client;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Serializer\Action\WebhookInfoSerializer;
use Temkaa\Botifier\Serializer\Serializer;
use Temkaa\Botifier\Utils\Description;
use Tests\Helper\Service\Http\GuzzleHttpClient;

final class DescriptionTest extends TestCase
{
    private readonly GuzzleHttpClient $client;

    private readonly Description $description;

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
                            'description' => 'description set',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->description->set('some description', Language::English);

        self::assertTrue($response->success());
        self::assertTrue($response->getResult());
        self::assertEquals('description set', $response->getDescription());
        self::assertNull($response->getErrorCode());
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
                            'description' => 'description not set',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->description->set('description', Language::English);

        self::assertFalse($response->success());
        self::assertNull($response->getResult());
        self::assertEquals('description not set', $response->getDescription());
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
                            'description' => 'description unset',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->description->unset(Language::English);

        self::assertTrue($response->success());
        self::assertTrue($response->getResult());
        self::assertEquals('description unset', $response->getDescription());
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
                            'description' => 'description not unset',
                        ],
                        JSON_THROW_ON_ERROR,
                    ),
                ),
            ],
        );

        $response = $this->description->unset();

        self::assertFalse($response->success());
        self::assertNull($response->getResult());
        self::assertEquals('description not unset', $response->getDescription());
        self::assertEquals(400, $response->getErrorCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new GuzzleHttpClient();
        $this->description = new Description(
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
