<?php

declare(strict_types=1);

namespace Tests\Helper\Service\Http;

use BadMethodCallException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GuzzleHttpClient implements ClientInterface
{
    /**
     * @var list<ResponseInterface>
     */
    private array $responses = [];

    public function getConfig(?string $option = null): void
    {
        throw new BadMethodCallException('Not implemented');
    }

    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        return array_shift($this->responses);
    }

    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        throw new BadMethodCallException('Not implemented');
    }

    public function reset(): void
    {
        $this->responses = [];
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        throw new BadMethodCallException('Not implemented');
    }

    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        throw new BadMethodCallException('Not implemented');
    }

    /**
     * @param list<ResponseInterface> $responses
     */
    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }
}
