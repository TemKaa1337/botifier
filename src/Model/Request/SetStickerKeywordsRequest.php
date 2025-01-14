<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetStickerKeywordsResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetStickerKeywordsResponse>
 */
final readonly class SetStickerKeywordsRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param string[]|null $keywords
     */
    public function __construct(
        public string $sticker,
        public ?array $keywords = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetStickerKeywords;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'sticker'  => $this->sticker,
                'keywords' => $this->keywords,
            ]
        );
    }
}
