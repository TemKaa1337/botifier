<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service\Telegram;

use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\ResponseInterface;

/**
 * @api
 */
interface ClientInterface
{
    /**
     * @template TResponse of ResponseInterface
     *
     * @param RequestInterface<TResponse> $request
     *
     * @return TResponse
     */
    public function reply(RequestInterface $request, Update $update): ResponseInterface;

    /**
     * @template TResponse of ResponseInterface
     *
     * @param RequestInterface<TResponse> $request
     *
     * @return TResponse
     */
    public function send(RequestInterface $request): ResponseInterface;
}
