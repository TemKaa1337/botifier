<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\DeleteMyCommandsResponse;
use Temkaa\Botifier\Model\Shared\BotCommandScopeAllChatAdministrators;
use Temkaa\Botifier\Model\Shared\BotCommandScopeAllGroupChats;
use Temkaa\Botifier\Model\Shared\BotCommandScopeAllPrivateChats;
use Temkaa\Botifier\Model\Shared\BotCommandScopeChat;
use Temkaa\Botifier\Model\Shared\BotCommandScopeChatAdministrators;
use Temkaa\Botifier\Model\Shared\BotCommandScopeChatMember;
use Temkaa\Botifier\Model\Shared\BotCommandScopeDefault;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<DeleteMyCommandsResponse>
 */
final readonly class DeleteMyCommandsRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public BotCommandScopeDefault|BotCommandScopeAllPrivateChats|BotCommandScopeAllGroupChats|BotCommandScopeAllChatAdministrators|BotCommandScopeChat|BotCommandScopeChatAdministrators|BotCommandScopeChatMember|null $scope = null,
        public ?Language $languageCode = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteMyCommands;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'scope'         => $this->scope?->format() ?: null,
                'language_code' => $this->languageCode?->value ?: null,
            ]
        );
    }
}
