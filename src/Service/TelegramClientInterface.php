<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;

/**
 * @api
 */
interface TelegramClientInterface
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
