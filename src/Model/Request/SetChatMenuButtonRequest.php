<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatMenuButtonResponse;
use Temkaa\Botifier\Model\Shared\MenuButtonCommands;
use Temkaa\Botifier\Model\Shared\MenuButtonDefault;
use Temkaa\Botifier\Model\Shared\MenuButtonWebApp;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetChatMenuButtonResponse>
 */
final readonly class SetChatMenuButtonRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public ?int $chatId = null,
        public MenuButtonCommands|MenuButtonWebApp|MenuButtonDefault|null $menuButton = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatMenuButton;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'     => $this->chatId,
                'menu_button' => $this->menuButton?->format() ?: null,
            ]
        );
    }
}
