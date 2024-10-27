<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\RequestInterface;
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
     * @param Bot                         $bot
     *
     * @return TResponse
     */
    public function send(RequestInterface $request, Bot $bot): ResponseInterface;
}
