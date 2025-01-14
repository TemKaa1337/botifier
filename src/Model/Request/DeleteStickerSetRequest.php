<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\DeleteStickerSetResponse;

/**
 * @api
 *
 * @implements RequestInterface<DeleteStickerSetResponse>
 */
final readonly class DeleteStickerSetRequest implements RequestInterface
{
    public function __construct(public string $name) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteStickerSet;
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
