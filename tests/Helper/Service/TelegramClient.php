<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Service\TelegramClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    /**
     * @var ResponseInterface[]
     */
    private array $responses = [];

    public function reset(): void
    {
        $this->responses = [];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedParameter)
     */
    public function send(RequestInterface $request, Bot $bot): ResponseInterface
    {
        return array_shift($this->responses);
    }

    /**
     * @param ResponseInterface[] $responses
     */
    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }
}
