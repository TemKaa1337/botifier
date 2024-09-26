<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

use GuzzleHttp\Promise\PromiseInterface;
use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Shared\Message;
use Temkaa\Botifier\Model\Shared\RequestInterface;

// TODO: implement
interface AsyncTelegramClientInterface
{
    /**
     * @return PromiseInterface<BaseResponse>
     */
    public function replyAsync(Message $message, Bot $bot, ?RequestInterface $request = null): PromiseInterface;

    /**
     * @return PromiseInterface<BaseResponse>
     */
    public function respondAsync(Message $message, Bot $bot, ?RequestInterface $request = null): PromiseInterface;

    /**
     * @return PromiseInterface<BaseResponse>
     */
    public function sendAsync(Action $action, Bot $bot, ?RequestInterface $request = null): PromiseInterface;
}
