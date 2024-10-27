<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Serializer\SerializerInterface;
use Temkaa\Botifier\Service\TelegramClient;

final class TelegramClientTest extends TestCase
{
    public function testSend(): void
    {
        $psrRequest = $this->createMock(PsrRequestInterface::class);
        $psrRequest->expects($this->once())->method('withBody')->willReturn($psrRequest);
        $psrRequest->expects($this->exactly(2))->method('withHeader')->willReturn($psrRequest);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->once())->method('sendRequest')->with($psrRequest);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->expects($this->once())->method('createRequest')->willReturn($psrRequest);

        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $streamFactory->expects($this->once())->method('createStream');

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())->method('deserialize');

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
            ->method('getParameters');

        $bot = $this->createMock(Bot::class);
        $bot->expects($this->once())->method('getToken');

        $client = new TelegramClient($httpClient, $requestFactory, $streamFactory, $serializer);
        $client->send($request, $bot);
    }
}
