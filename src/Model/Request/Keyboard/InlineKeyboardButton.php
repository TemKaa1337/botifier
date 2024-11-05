<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

// TODO: add test on this
use Temkaa\Botifier\Trait\NullableArrayFilterTrait;

final readonly class InlineKeyboardButton
{
    use NullableArrayFilterTrait;

    public function __construct(
        private string $text,
        private ?string $url = null,
        private ?string $callbackData = null,
        private ?WebApp $webApp = null,
        private ?LoginUrl $loginUrl = null,
        private ?string $switchInlineQuery = null,
        private ?string $switchInlineQueryCurrentChat = null,
        private ?SwitchInlineQueryChosenChat $switchInlineQueryChosenChat = null,
        private ?CopyTextButton $copyText = null,
        private ?bool $pay = null,
    ) {
    }

    public function format(): array
    {
        $data = [
            'text'                             => $this->text,
            'url'                              => $this->url,
            'callback_data'                    => $this->callbackData,
            'web_app'                          => $this->webApp?->format() ?: null,
            'login_url'                        => $this->loginUrl?->format() ?: null,
            'switch_inline_query'              => $this->switchInlineQuery,
            'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
            'switch_inline_query_chosen_chat'  => $this->switchInlineQueryChosenChat?->format() ?: null,
            'copy_text'                        => $this->copyText?->format() ?: null,
            'pay'                              => $this->pay,
        ];

        return $this->filter($data);
    }
}
