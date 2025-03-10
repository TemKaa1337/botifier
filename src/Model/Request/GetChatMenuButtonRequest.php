<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetChatMenuButtonResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetChatMenuButtonResponse>
 */
final readonly class GetChatMenuButtonRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(public ?int $chatId = null) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetChatMenuButton;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id' => $this->chatId,
            ]
        );
    }
}
