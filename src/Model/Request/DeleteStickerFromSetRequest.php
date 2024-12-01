<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\DeleteStickerFromSetResponse;

/**
 * @api
 *
 * @implements RequestInterface<DeleteStickerFromSetResponse>
 */
final readonly class DeleteStickerFromSetRequest implements RequestInterface
{
    public function __construct(public string $sticker) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteStickerFromSet;
    }

    public function getData(): array
    {
        return [
            'sticker' => $this->sticker,
        ];
    }
}
