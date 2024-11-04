<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Serializer\SerializerInterface;
use Temkaa\Botifier\Service\TelegramClient;

final class TelegramClientTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testReply(): void
    {
        $psrRequest1 = $this->createMock(PsrRequestInterface::class);
        $psrRequest2 = $this->createMock(PsrRequestInterface::class);
        $psrRequest1
            ->expects($this->once())
            ->method('withBody')
            ->willReturn($psrRequest1);
        $psrRequest1
            ->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json; charset=utf-8')
            ->willReturn($psrRequest2);
        $psrRequest2
            ->expects($this->once())
            ->method('withHeader')
            ->with('Content-Length', '10')
            ->willReturn($psrRequest2);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with($psrRequest2);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/botbot_token/getUpdates')
            ->willReturn($psrRequest1);

        $body = $this->createMock(StreamInterface::class);
        $body
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(10);

        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $streamFactory
            ->expects($this->once())
            ->method('createStream')
            ->with(json_encode(['text' => 'some text here', 'reply_to_message_id' => 100]))
            ->willReturn($body);

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer
            ->expects($this->once())
            ->method('deserialize');

        $request = $this->createMock(RequestInterface::class);
        $request
            ->expects($this->exactly(2))
            ->method('getApiMethod')
            ->willReturn(ApiMethod::GetUpdates);
        $request
            ->expects($this->once())
            ->method('getHttpMethod')
            ->willReturn(HttpMethod::Post);
        $request
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn(['text' => 'some text here']);

        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $message = $this->createMock(Message::class);
        $message
            ->expects($this->once())
            ->method('getId')
            ->willReturn(100);

        $client = new TelegramClient($httpClient, $requestFactory, $streamFactory, $serializer, 'bot_token');
        $client->reply($request, $message);
    }

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        $psrRequest1 = $this->createMock(PsrRequestInterface::class);
        $psrRequest2 = $this->createMock(PsrRequestInterface::class);
        $psrRequest1
            ->expects($this->once())
            ->method('withBody')
            ->willReturn($psrRequest1);
        $psrRequest1
            ->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json; charset=utf-8')
            ->willReturn($psrRequest2);
        $psrRequest2
            ->expects($this->once())
            ->method('withHeader')
            ->with('Content-Length', '10')
            ->willReturn($psrRequest2);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with($psrRequest2);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/botbot_token/getUpdates')
            ->willReturn($psrRequest1);

        $body = $this->createMock(StreamInterface::class);
        $body
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(10);

        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $streamFactory
            ->expects($this->once())
            ->method('createStream')
            ->with(json_encode(['text' => 'some text here']))
            ->willReturn($body);

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer
            ->expects($this->once())
            ->method('deserialize');

        $request = $this->createMock(RequestInterface::class);
        $request
            ->expects($this->exactly(2))
            ->method('getApiMethod')
            ->willReturn(ApiMethod::GetUpdates);
        $request
            ->expects($this->once())
            ->method('getHttpMethod')
            ->willReturn(HttpMethod::Post);
        $request
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn(['text' => 'some text here']);

        $client = new TelegramClient($httpClient, $requestFactory, $streamFactory, $serializer, 'bot_token');
        $client->send($request);
    }
}
