<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendMessageResponse;
use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendMessageResponse>
 */
// TODO: add test on this
final readonly class ReplyKeyboardRemoveRequest implements RequestInterface
{
    use NullableArrayFilterTrait;

    public function __construct(
        private int $chatId,
        private string $text,
        private bool $removeKeyboard,
        private ?bool $selective = null,
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
        return [
            'chat_id'      => $this->chatId,
            'text'         => $this->text,
            'reply_markup' => [
                ...$this->filter(
                    [
                        'remove_keyboard' => $this->removeKeyboard,
                        'selective'       => $this->selective,
                    ],
                ),
            ],
        ];
    }
}
