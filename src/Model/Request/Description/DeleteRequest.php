<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Description;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Enum\Language;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GeneralResponse;

/**
 * @api
 * @implements RequestInterface<GeneralResponse>
 */
final readonly class DeleteRequest implements RequestInterface
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
