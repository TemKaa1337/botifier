<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerSetTitleResponse;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerSetTitleResponse>
 */
final readonly class SetStickerSetTitleRequest implements RequestInterface
{
    public function __construct(
        public string $name,
        public string $title
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerSetTitle;
    }

    public function getData(): array
    {
        return [
            'name'  => $this->name,
            'title' => $this->title,
        ];
    }
}
