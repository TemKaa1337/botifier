<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Shared\RequestInterface;
use Temkaa\Botifier\Serializer\SerializerInterface;

// TODO: change this to interface and inject interface everywhere it is possible
final readonly class TelegramClient implements TelegramClientInterface
{
    private const string BASE_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private ClientInterface $client,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function send(Action $action, Bot $bot, ?RequestInterface $request = null): BaseResponse
    {
        // TODO: think about settings more dependencies in constructor
        // TODO: add interface here? some sort of send/sendAsync etc
        // TODO: add some layout between here and options (to allow sending photos/text/images/videos/stickers etc)
        $url = sprintf('%s/bot%s/%s', self::BASE_URL, $bot->getToken(), $action->value);

        $options = ['form_params' => $request?->toArray() ?? [], 'http_errors' => false];

        $response = $this->client->request(method: 'POST', uri: $url, options: $options);

        return $this->serializer->deserialize(
            $action,
            $response->getBody()->getContents(),
        );
    }
}
