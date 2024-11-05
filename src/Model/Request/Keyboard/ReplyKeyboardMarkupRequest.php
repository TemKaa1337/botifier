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
final readonly class ReplyKeyboardMarkupRequest implements RequestInterface
{
    use NullableArrayFilterTrait;

    /**
     * @param KeyboardButton[][] $buttons
     */
    public function __construct(
        private int $chatId,
        private array $buttons,
        private ?bool $isPersistent = null,
        private ?bool $resizeKeyboard = null,
        private ?bool $oneTimeKeyboard = null,
        private ?string $inputFieldPlaceholder = null,
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
            'reply_markup' => [
                $this->filter(
                    [
                        'keyboard'                => array_map(
                            static fn (array $rowButtons): array => array_map(
                                static fn (KeyboardButton $button): array => $button->format(),
                                $rowButtons,
                            ),
                            $this->buttons,
                        ),
                        'is_persistent'           => $this->isPersistent,
                        'resize_keyboard'         => $this->resizeKeyboard,
                        'one_time_keyboard'       => $this->oneTimeKeyboard,
                        'input_field_placeholder' => $this->inputFieldPlaceholder,
                        'selective'               => $this->selective,
                    ],
                ),
            ],
        ];
    }
}
