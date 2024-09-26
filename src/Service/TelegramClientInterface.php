<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Shared\RequestInterface;

interface TelegramClientInterface
{
    public function send(Action $action, Bot $bot, ?RequestInterface $request = null): BaseResponse;
}
