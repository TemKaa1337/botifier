<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetMyNameResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetMyNameResponse>
 */
final readonly class SetMyNameRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public ?string $name = null,
        public ?Language $languageCode = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetMyName;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'name'          => $this->name,
                'language_code' => $this->languageCode?->value ?: null,
            ]
        );
    }
}
