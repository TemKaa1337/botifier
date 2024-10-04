<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Request\RequestInterface;
use Temkaa\Botifier\Model\Response\Response;
use Temkaa\Botifier\Service\TelegramClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    /**
     * @var Response[]
     */
    private array $responses = [];

    public function reset(): void
    {
        $this->responses = [];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedParameter)
     */
    public function send(RequestInterface $request, Bot $bot): Response
    {
        return array_shift($this->responses);
    }

    /**
     * @param Response[] $responses
     */
    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }
}
