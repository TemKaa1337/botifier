<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\Webhook;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetWebhookInfoResponse;

/**
 * @api
 * @implements RequestInterface<GetWebhookInfoResponse>
 */
final readonly class GetInfoRequest implements RequestInterface
{
    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetWebhookInfo;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Get;
    }

    public function getParameters(): array
    {
        return [];
    }
}
