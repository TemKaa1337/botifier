<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Temkaa\Botifier\Enum\Http\Action;

final class Client
{
    private const string TELEGRAM_BASE_URL = 'https://api.telegram.org/bot';

    public function __construct(
        private readonly GuzzleClient $client,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function request(Action $action, string $token, array $options = []): ResponseInterface
    {
        $url = sprintf('%s/bot%s/%s', self::TELEGRAM_BASE_URL, $token, $action->value);

        return $this->client->request(method: 'GET', uri: $url, options: $options);
    }
}
