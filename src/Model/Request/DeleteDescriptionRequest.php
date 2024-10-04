<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;

/**
 * @api
 */
final readonly class DeleteDescriptionRequest implements RequestInterface
{
    public function __construct(
        private ?Language $language,
    ) {
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteDescription;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        return $this->language ? ['language_code' => $this->language->value] : [];
    }
}
