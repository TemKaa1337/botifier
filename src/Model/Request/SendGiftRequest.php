<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendGiftResponse;
use Temkaa\Botifier\Model\Shared\MessageEntity;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendGiftResponse>
 */
final readonly class SendGiftRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public int $userId,
        public string $giftId,
        public ?string $text = null,
        public ?string $textParseMode = null,
        public ?array $textEntities = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendGift;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'user_id'         => $this->userId,
                'gift_id'         => $this->giftId,
                'text'            => $this->text,
                'text_parse_mode' => $this->textParseMode,
                'text_entities'   => $this->textEntities === null
                    ? null
                    : array_map(
                        static fn (MessageEntity $type): array => $type->format(),
                        $this->textEntities
                    ),
            ]
        );
    }
}
