<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetWebhookResponse;
use Temkaa\Botifier\Model\Shared\InputFile;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetWebhookResponse>
 */
final readonly class SetWebhookRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        public string $url,
        public ?InputFile $certificate = null,
        public ?string $ipAddress = null,
        public ?int $maxConnections = null,
        public ?array $allowedUpdates = null,
        public ?bool $dropPendingUpdates = null,
        public ?string $secretToken = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetWebhook;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'url'                  => $this->url,
                'certificate'          => $this->certificate?->format() ?: null,
                'ip_address'           => $this->ipAddress,
                'max_connections'      => $this->maxConnections,
                'allowed_updates'      => $this->allowedUpdates,
                'drop_pending_updates' => $this->dropPendingUpdates,
                'secret_token'         => $this->secretToken,
            ]
        );
    }
}
