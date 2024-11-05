<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SensitiveParameter;
use Temkaa\Botifier\Model\File;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Serializer\SerializerInterface;

/**
 * @api
 */
final readonly class TelegramClient implements TelegramClientInterface
{
    private const string BASE_URL = 'https://api.telegram.org';

    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $httpStreamFactory,
        private SerializerInterface $serializer,
        #[SensitiveParameter] private string $token,
    ) {
    }

    public function reply(RequestInterface $request, Message $replyTo): ResponseInterface
    {
        return $this->sendRequest($request, $replyTo);
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    private function sendRequest(RequestInterface $request, ?Message $reply = null): ResponseInterface
    {
        $url = sprintf('%s/bot%s/%s', self::BASE_URL, $this->token, $request->getApiMethod()->value);

        $data = $reply
            ? [...$request->getParameters(), 'reply_to_message_id' => $reply->getId()]
            : $request->getParameters();

        /** @var array<string, File> $files */
        $files = [];

        foreach ($data as $name => $value) {
            if ($value instanceof File) {
                $files[$name] = $value;
                unset($data[$name]);
            }
        }

        if ($files) {
            $multipartStreamBuilder = new MultipartStreamBuilder($this->httpStreamFactory);

            foreach ($data as $name => $value) {
                $multipartStreamBuilder->addResource(
                    $name,
                    is_string($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
                );
            }
            foreach ($files as $name => $file) {
                $fileName = $file->getFileName();
                $fileNameInfo = $fileName !== null ? ['filename' => $fileName] : [];

                $multipartStreamBuilder->addResource($name, $file->getContent(), $fileNameInfo);
            }

            $body = $multipartStreamBuilder->build();
            $contentType = sprintf(
                'multipart/form-data; boundary=%s; charset=utf-8',
                $multipartStreamBuilder->getBoundary(),
            );
        } else {
            $body = $this->httpStreamFactory->createStream(json_encode($data, JSON_THROW_ON_ERROR));

            $contentType = 'application/json; charset=utf-8';
        }

        $httpRequest = $this->httpRequestFactory
            ->createRequest($request->getHttpMethod()->value, $url)
            ->withBody($body)
            ->withHeader('Content-Type', $contentType)
            ->withHeader('Content-Length', (string) $body->getSize());

        $response = $this->httpClient->sendRequest($httpRequest);

        return $this->serializer->deserialize(
            $request->getApiMethod(),
            $response->getBody()->getContents(),
        );
    }
}
