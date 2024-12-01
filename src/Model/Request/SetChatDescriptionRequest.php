<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatDescriptionResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetChatDescriptionResponse>
 */
final readonly class SetChatDescriptionRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public ?string $description = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatDescription;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'     => $this->chatId,
                'description' => $this->description,
            ]
        );
    }
}
