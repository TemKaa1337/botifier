<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use LogicException;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Service\TelegramClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    /**
     * @var ResponseInterface[]
     */
    private array $responses = [];

    public function reply(RequestInterface $request, Update $update): ResponseInterface
    {
        throw new LogicException('Not implemented');
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
