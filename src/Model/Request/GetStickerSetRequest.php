<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\GetStickerSetResponse;

/**
 * @api
 *
 * @implements RequestInterface<GetStickerSetResponse>
 */
final readonly class GetStickerSetRequest implements RequestInterface
{
    public function __construct(public string $name) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetStickerSet;
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
