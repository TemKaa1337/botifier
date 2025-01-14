<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetCustomEmojiStickersResponse;

/**
 * @api
 *
 * @implements RequestInterface<GetCustomEmojiStickersResponse>
 */
final readonly class GetCustomEmojiStickersRequest implements RequestInterface
{
    /**
     * @param string[] $customEmojiIds
     */
    public function __construct(public array $customEmojiIds) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetCustomEmojiStickers;
    }

    public function getData(): array
    {
        return [
            'custom_emoji_ids' => $this->customEmojiIds,
        ];
    }
}
