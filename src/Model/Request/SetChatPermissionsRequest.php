<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatPermissionsResponse;
use Temkaa\Botifier\Model\Shared\ChatPermissions;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetChatPermissionsResponse>
 */
final readonly class SetChatPermissionsRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public ChatPermissions $permissions,
        public ?bool $useIndependentChatPermissions = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatPermissions;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                          => $this->chatId,
                'permissions'                      => $this->permissions->format(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
            ]
        );
    }
}
