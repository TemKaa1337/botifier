<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetMessageReactionResponse;
use Temkaa\Botifier\Model\Shared\ReactionTypeCustomEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypeEmoji;
use Temkaa\Botifier\Model\Shared\ReactionTypePaid;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetMessageReactionResponse>
 */
final readonly class SetMessageReactionRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param ReactionTypeEmoji[]|ReactionTypeCustomEmoji[]|ReactionTypePaid[]|null $reaction
     */
    public function __construct(
        public int|string $chatId,
        public int $messageId,
        public ?array $reaction = null,
        public ?bool $isBig = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetMessageReaction;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'    => $this->chatId,
                'message_id' => $this->messageId,
                'reaction'   => $this->reaction === null
                    ? null
                    : array_map(
                        static fn (ReactionTypeEmoji|ReactionTypeCustomEmoji|ReactionTypePaid $type): array => $type->format(),
                        $this->reaction
                    ),
                'is_big'     => $this->isBig,
            ]
        );
    }
}
