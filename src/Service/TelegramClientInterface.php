<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Message;
use Temkaa\Botifier\Model\ResponseInterface;

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
    public function reply(RequestInterface $request, Message $replyTo): ResponseInterface;

    /**
     * @template TResponse of ResponseInterface
     *
     * @param RequestInterface<TResponse> $request
     *
     * @return TResponse
     */
    public function send(RequestInterface $request): ResponseInterface;
}
