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
            'text' => $this->text,
            'url' => $this->url,
            'callback_data' => $this->callbackData,
            'web_app' => $this->webApp?->format(),
            'login_url' => $this->loginUrl?->format(),
            'switch_inline_query' => $this->switchInlineQuery,
            'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
            'switch_inline_query_chosen_chat' => $this->switchInlineQueryChosenChat?->format(),
            'copy_text' => $this->copyText?->format(),
            'pay' => $this->pay,
        ];

        return $this->filter($data);
        // $data = ['text' => $this->text];
        // if ($this->url !== null) {
        //     $data['url'] = $this->url;
        // }
        //
        // if ($this->callbackData !== null) {
        //     $data['callback_data'] = $this->callbackData;
        // }
        //
        // if ($webApp = $this->webApp?->format()) {
        //     $data['web_app'] = $webApp;
        // }
        //
        // $loginUrl = $this->loginUrl?->format();
        // if ($loginUrl !== null && $loginUrl = $this->filter($loginUrl)) {
        //     $data['login_url'] = $loginUrl;
        // }
        //
        // if ($this->switchInlineQuery !== null) {
        //     $data['switch_inline_query'] = $this->switchInlineQuery;
        // }
        //
        // if ($this->switchInlineQueryCurrentChat !== null) {
        //     $data['switch_inline_query_current_chat'] = $this->switchInlineQueryCurrentChat;
        // }
        //
        // $switchInlineQueryChosenChat = $this->switchInlineQueryChosenChat?->format();
        // if (
        //     $switchInlineQueryChosenChat !== null
        //     && $switchInlineQueryChosenChat = $this->filter($switchInlineQueryChosenChat)
        // ) {
        //     $data['switch_inline_query_chosen_chat'] = $switchInlineQueryChosenChat;
        // }
        //
        // $copyText = $this->copyText?->format();
        // if ($copyText !== null && $copyText = $this->filter($copyText)) {
        //     $data['copy_text'] = $copyText;
        // }
        //
        // if ($this->pay !== null) {
        //     $data['pay'] = $this->pay;
        // }

        // return $data;
    }
}
