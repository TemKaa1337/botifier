<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;

/**
 * @api
 */
final readonly class SetDescriptionRequest implements RequestInterface
{
    public function __construct(
        private string $description,
        private Language $language,
    ) {
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetDescription;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        return ['description' => $this->description, 'language_code' => $this->language->value];
    }
}
