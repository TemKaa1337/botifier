<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerMaskPositionResponse;
use Temkaa\Botifier\Model\Shared\MaskPosition;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerMaskPositionResponse>
 */
final readonly class SetStickerMaskPositionRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public string $sticker,
        public ?MaskPosition $maskPosition = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerMaskPosition;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'sticker'       => $this->sticker,
                'mask_position' => $this->maskPosition?->format() ?: null,
            ]
        );
    }
}
