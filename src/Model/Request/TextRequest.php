<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendMessageResponse;

/**
 * @api
 * @implements RequestInterface<SendMessageResponse>
 */
final readonly class TextRequest implements RequestInterface
{
    public function __construct(
        private int $chatId,
        private string $text,
    ) {
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendMessage;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        return ['chat_id' => $this->chatId, 'text' => $this->text];
    }
}
