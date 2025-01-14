<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\AnswerPreCheckoutQueryResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<AnswerPreCheckoutQueryResponse>
 */
final readonly class AnswerPreCheckoutQueryRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public string $preCheckoutQueryId,
        public bool $ok,
        public ?string $errorMessage = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::AnswerPreCheckoutQuery;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'pre_checkout_query_id' => $this->preCheckoutQueryId,
                'ok'                    => $this->ok,
                'error_message'         => $this->errorMessage,
            ]
        );
    }
}
