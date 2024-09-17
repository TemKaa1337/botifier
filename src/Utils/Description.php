<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Utils;

use GuzzleHttp\Exception\GuzzleException;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Http\Client;
use Temkaa\Botifier\Model\Api\Response;
use Temkaa\Botifier\Model\Bot;

final readonly class Description
{
    public function __construct(
        private Bot $bot,
        private Client $client,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function set(string $description, Language $language): Response
    {
        return $this->client->send(
            Action::SetDescription,
            $this->bot,
            options: ['description' => $description, 'language_code' => $language->value],
        );
    }

    /**
     * @throws GuzzleException
     */
    public function unset(?Language $language = null): Response
    {
        return $this->client->send(
            Action::DeleteDescription,
            $this->bot,
            options: $language ? ['language_code' => $language->value] : [],
        );
    }
}
