<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\GetMyShortDescriptionResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetMyShortDescriptionResponse>
 */
final readonly class GetMyShortDescriptionRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(public ?Language $languageCode = null) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetMyShortDescription;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'language_code' => $this->languageCode?->value ?: null,
            ]
        );
    }
}
