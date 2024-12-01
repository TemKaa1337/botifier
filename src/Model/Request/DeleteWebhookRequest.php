<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\DeleteWebhookResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<DeleteWebhookResponse>
 */
final readonly class DeleteWebhookRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(public ?bool $dropPendingUpdates = null) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::DeleteWebhook;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'drop_pending_updates' => $this->dropPendingUpdates,
            ]
        );
    }
}
