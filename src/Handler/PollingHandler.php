<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Handler;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use ReflectionException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Enum\Http\StatusCode;
use Temkaa\Botifier\Provider\CommandProvider;
use Temkaa\Botifier\Provider\MessageProvider;
use Temkaa\Botifier\Service\Http\Client;

final class PollingHandler implements HandlerInterface
{
    public function __construct(
        private readonly CommandProvider $commandProvider,
        private readonly MessageProvider $messageProvider,
        private readonly Client $client,
    ) {
    }

    /**
     * @throws JsonException
     * @throws ReflectionException
     * @throws GuzzleException
     */
    public function handle(string $token): void
    {
        /**
         * 1. each N seconds get updates
         */

        $response = $this->client->request(Action::GetUpdates, $token);

        if ($response->getStatusCode() !== StatusCode::Success->value) {
            throw new ClientException($response->getReasonPhrase(), $response->getStatusCode());
        }


        $message = $this->messageProvider->provide();

        $this->commandProvider->provide($message)->handle($message);
    }
}
