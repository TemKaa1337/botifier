<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendMessageResponse;

/**
 * @TODO: add test on this
 * @api
 *
 * @implements RequestInterface<SendMessageResponse>
 */
final readonly class InlineKeyboardMarkupRequest implements RequestInterface
{
    /**
     * @param InlineKeyboardButton[][] $buttons
     */
    public function __construct(
        private int $chatId,
        private string $text,
        private array $buttons,
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
                'inline_keyboard' => array_map(
                    static fn (array $rowButtons): array => array_map(
                        static fn (InlineKeyboardButton $button): array => $button->format(),
                        $rowButtons,
                    ),
                    $this->buttons,
                ),
            ],
        ];
    }
}
