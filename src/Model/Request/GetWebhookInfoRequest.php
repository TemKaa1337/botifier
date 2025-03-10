<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetWebhookInfoResponse;

/**
 * @api
 *
 * @implements RequestInterface<GetWebhookInfoResponse>
 */
final readonly class GetWebhookInfoRequest implements RequestInterface
{
    public function __construct() {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetWebhookInfo;
    }

    public function getData(): array
    {
        return [];
    }
}
