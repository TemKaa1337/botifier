<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerSetThumbnailResponse;
use Temkaa\Botifier\Model\Shared\InputFile;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerSetThumbnailResponse>
 */
final readonly class SetStickerSetThumbnailRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public string $name,
        public int $userId,
        public string $format,
        public InputFile|string|null $thumbnail = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerSetThumbnail;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'name'      => $this->name,
                'user_id'   => $this->userId,
                'format'    => $this->format,
                'thumbnail' => is_object($this->thumbnail) ? $this->thumbnail->format() : $this->thumbnail,
            ]
        );
    }
}
