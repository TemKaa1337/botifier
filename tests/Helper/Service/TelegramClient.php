<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use Temkaa\Botifier\Enum\Http\Action;
use Temkaa\Botifier\Model\Api\Response\BaseResponse;
use Temkaa\Botifier\Model\Bot;
use Temkaa\Botifier\Model\Shared\RequestInterface;
use Temkaa\Botifier\Service\TelegramClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    /**
     * @var BaseResponse[]
     */
    private array $responses = [];

    public function reset(): void
    {
        $this->responses = [];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedParameter)
     */
    public function send(Action $action, Bot $bot, ?RequestInterface $request = null): BaseResponse
    {
        return array_shift($this->responses);
    }

    /**
     * @param BaseResponse[] $responses
     */
    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }
}
