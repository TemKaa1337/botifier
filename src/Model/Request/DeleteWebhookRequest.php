<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;

/**
 * @api
 */
final readonly class DeleteWebhookRequest implements RequestInterface
{
    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteWebhook;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        return [];
    }
}
