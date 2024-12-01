<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetMyDefaultAdministratorRightsResponse;
use Temkaa\Botifier\Model\Shared\ChatAdministratorRights;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetMyDefaultAdministratorRightsResponse>
 */
final readonly class SetMyDefaultAdministratorRightsRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public ?ChatAdministratorRights $rights = null,
        public ?bool $forChannels = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetMyDefaultAdministratorRights;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'rights'       => $this->rights?->format() ?: null,
                'for_channels' => $this->forChannels,
            ]
        );
    }
}
