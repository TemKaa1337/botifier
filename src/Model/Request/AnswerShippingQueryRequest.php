<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\AnswerShippingQueryResponse;
use Temkaa\Botifier\Model\Shared\ShippingOption;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<AnswerShippingQueryResponse>
 */
final readonly class AnswerShippingQueryRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param ShippingOption[]|null $shippingOptions
     */
    public function __construct(
        public string $shippingQueryId,
        public bool $ok,
        public ?array $shippingOptions = null,
        public ?string $errorMessage = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::AnswerShippingQuery;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'shipping_query_id' => $this->shippingQueryId,
                'ok'                => $this->ok,
                'shipping_options'  => $this->shippingOptions === null
                    ? null
                    : array_map(
                        static fn (ShippingOption $type): array => $type->format(),
                        $this->shippingOptions
                    ),
                'error_message'     => $this->errorMessage,
            ]
        );
    }
}
