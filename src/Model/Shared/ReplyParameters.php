<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use Temkaa\Botifier\Trait\ArrayFilterTrait;

final readonly class ReplyParameters
{
    use ArrayFilterTrait;

    /**
     * @param MessageEntity[]|null $quoteEntities
     */
    public function __construct(
        public int $messageId,
        public int|string|null $chatId = null,
        public ?bool $allowSendingWithoutReply = null,
        public ?string $quote = null,
        public ?string $quoteParseMode = null,
        public ?array $quoteEntities = null,
        public ?int $quotePosition = null
    ) {}

    public function format(): array
    {
        return $this->filterNullable(
            [
                'message_id'                  => $this->messageId,
                'chat_id'                     => $this->chatId,
                'allow_sending_without_reply' => $this->allowSendingWithoutReply,
                'quote'                       => $this->quote,
                'quote_parse_mode'            => $this->quoteParseMode,
                'quote_entities'              => $this->quoteEntities === null
                    ? null
                    : array_map(
                        static fn (MessageEntity $type): array => $type->format(),
                        $this->quoteEntities
                    ),
                'quote_position'              => $this->quotePosition,
            ]
        );
    }
}
