<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetGameHighScoresResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<GetGameHighScoresResponse>
 */
final readonly class GetGameHighScoresRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int $userId,
        public ?int $chatId = null,
        public ?int $messageId = null,
        public ?string $inlineMessageId = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetGameHighScores;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'user_id'           => $this->userId,
                'chat_id'           => $this->chatId,
                'message_id'        => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
            ]
        );
    }
}
