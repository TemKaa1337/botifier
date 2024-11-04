<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use LogicException;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Service\TelegramClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    /**
     * @var ResponseInterface[]
     */
    private array $responses = [];

    public function reply(RequestInterface $request, Message $replyTo): ResponseInterface
    {
        throw new LogicException('Not implemented.');
    }

    public function reset(): void
    {
        $this->responses = [];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedParameter)
     */
    public function send(RequestInterface $request): ResponseInterface
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
