<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Input\Message;
use Temkaa\Botifier\Serializer\SerializerInterface;

// TODO: change this to interface and inject interface everywhere it is possible
final class Client
{
    private const string BASE_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private readonly ClientInterface $client,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function send(Action $action, Bot $bot, array $options = []): Response
    {
        // TODO: add interface here? some sort of send/sendAsync etc
        // TODO: add some layout between here and options (to allow sending photos/text/images/videos/stickers etc)
        $url = sprintf('%s/bot%s/%s', self::BASE_URL, $bot->getToken(), $action->value);

        $response = $this->client->request(method: 'POST', uri: $url, options: $options);

        return $this->serializer->deserialize(
            $action,
            $response->getBody()->getContents(),
        );
    }

    public function respond(Message $message): void
    {
        // TODO: just send response to this chat id and this user (do not reply to specific message)
    }

    public function reply(Message $message): void
    {
        // TODO: just reply to THIS specific message with given content
    }
}
