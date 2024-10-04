<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Request\RequestInterface;
use Temkaa\Botifier\Model\Response\Response;

/**
 * @api
 */
interface TelegramClientInterface
{
    public function send(RequestInterface $request, Bot $bot): Response;
}
