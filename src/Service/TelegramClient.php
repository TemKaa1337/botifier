<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Request\RequestInterface;
use Temkaa\Botifier\Model\Response\Response;
use Temkaa\Botifier\Serializer\SerializerInterface;

/**
 * @api
 */
final readonly class TelegramClient implements TelegramClientInterface
{
    private const string BASE_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $httpStreamFactoryInterface,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function send(RequestInterface $request, Bot $bot): Response
    {
        // TODO: think about settings more dependencies in constructor
        // TODO: add interface here? some sort of send/sendAsync etc
        // TODO: add some layout between here and options (to allow sending photos/text/images/videos/stickers etc)
        $url = sprintf('%s/bot%s/%s', self::BASE_URL, $bot->getToken(), $request->getApiMethod()->value);

        $body = $this->httpStreamFactoryInterface->createStream(
            json_encode($request->getParameters(), JSON_THROW_ON_ERROR)
        );

        // TODO: handle files here
        $httpRequest = $this->httpRequestFactory
            ->createRequest($request->getHttpMethod()->value, $url)
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Content-Length', (string) $body->getSize());

        $response = $this->httpClient->sendRequest($httpRequest);

        return $this->serializer->deserialize(
            $request->getApiMethod(),
            $response->getBody()->getContents(),
        );
    }
}
