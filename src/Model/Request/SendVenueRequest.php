<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendVenueResponse;
use Temkaa\Botifier\Model\Shared\ForceReply;
use Temkaa\Botifier\Model\Shared\InlineKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardRemove;
use Temkaa\Botifier\Model\Shared\ReplyParameters;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendVenueResponse>
 */
final readonly class SendVenueRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int|string $chatId,
        public float $latitude,
        public float $longitude,
        public string $title,
        public string $address,
        public ?string $businessConnectionId = null,
        public ?int $messageThreadId = null,
        public ?string $foursquareId = null,
        public ?string $foursquareType = null,
        public ?string $googlePlaceId = null,
        public ?string $googlePlaceType = null,
        public ?bool $disableNotification = null,
        public ?bool $protectContent = null,
        public ?bool $allowPaidBroadcast = null,
        public ?string $messageEffectId = null,
        public ?ReplyParameters $replyParameters = null,
        public ForceReply|InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|null $replyMarkup = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendVenue;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                => $this->chatId,
                'latitude'               => $this->latitude,
                'longitude'              => $this->longitude,
                'title'                  => $this->title,
                'address'                => $this->address,
                'business_connection_id' => $this->businessConnectionId,
                'message_thread_id'      => $this->messageThreadId,
                'foursquare_id'          => $this->foursquareId,
                'foursquare_type'        => $this->foursquareType,
                'google_place_id'        => $this->googlePlaceId,
                'google_place_type'      => $this->googlePlaceType,
                'disable_notification'   => $this->disableNotification,
                'protect_content'        => $this->protectContent,
                'allow_paid_broadcast'   => $this->allowPaidBroadcast,
                'message_effect_id'      => $this->messageEffectId,
                'reply_parameters'       => $this->replyParameters?->format() ?: null,
                'reply_markup'           => $this->replyMarkup?->format() ?: null,
            ]
        );
    }
}
