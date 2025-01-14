<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetUserEmojiStatusResponse;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SetUserEmojiStatusResponse>
 */
final readonly class SetUserEmojiStatusRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int $userId,
        public ?string $emojiStatusCustomEmojiId = null,
        public ?DateTimeImmutable $emojiStatusExpirationDate = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetUserEmojiStatus;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'user_id'                      => $this->userId,
                'emoji_status_custom_emoji_id' => $this->emojiStatusCustomEmojiId,
                'emoji_status_expiration_date' => $this->emojiStatusExpirationDate?->setTimezone(new DateTimeZone('UTC'))?->getTimestamp() ?: null,
            ]
        );
    }
}
