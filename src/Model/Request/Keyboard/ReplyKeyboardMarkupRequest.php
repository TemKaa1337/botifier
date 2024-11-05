<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Keyboard;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;

final readonly class ReplyKeyboardMarkupRequest implements RequestInterface
{
    /**
     * @param KeyboardButton[][] $buttons
     */
    public function __construct(
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
        $data = [];

        return $data;
    }
}
