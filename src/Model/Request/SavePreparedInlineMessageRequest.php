<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SavePreparedInlineMessageResponse;
use Temkaa\Botifier\Model\Shared\InlineQueryResultArticle;
use Temkaa\Botifier\Model\Shared\InlineQueryResultAudio;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedAudio;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedDocument;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedGif;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedMpeg4Gif;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedPhoto;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedSticker;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedVideo;
use Temkaa\Botifier\Model\Shared\InlineQueryResultCachedVoice;
use Temkaa\Botifier\Model\Shared\InlineQueryResultContact;
use Temkaa\Botifier\Model\Shared\InlineQueryResultDocument;
use Temkaa\Botifier\Model\Shared\InlineQueryResultGame;
use Temkaa\Botifier\Model\Shared\InlineQueryResultGif;
use Temkaa\Botifier\Model\Shared\InlineQueryResultLocation;
use Temkaa\Botifier\Model\Shared\InlineQueryResultMpeg4Gif;
use Temkaa\Botifier\Model\Shared\InlineQueryResultPhoto;
use Temkaa\Botifier\Model\Shared\InlineQueryResultVenue;
use Temkaa\Botifier\Model\Shared\InlineQueryResultVideo;
use Temkaa\Botifier\Model\Shared\InlineQueryResultVoice;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SavePreparedInlineMessageResponse>
 */
final readonly class SavePreparedInlineMessageRequest implements RequestInterface
{
    use ArrayFilterTrait;

    public function __construct(
        public int $userId,
        public InlineQueryResultCachedAudio|InlineQueryResultCachedDocument|InlineQueryResultCachedGif|InlineQueryResultCachedMpeg4Gif|InlineQueryResultCachedPhoto|InlineQueryResultCachedSticker|InlineQueryResultCachedVideo|InlineQueryResultCachedVoice|InlineQueryResultArticle|InlineQueryResultAudio|InlineQueryResultContact|InlineQueryResultGame|InlineQueryResultDocument|InlineQueryResultGif|InlineQueryResultLocation|InlineQueryResultMpeg4Gif|InlineQueryResultPhoto|InlineQueryResultVenue|InlineQueryResultVideo|InlineQueryResultVoice $result,
        public ?bool $allowUserChats = null,
        public ?bool $allowBotChats = null,
        public ?bool $allowGroupChats = null,
        public ?bool $allowChannelChats = null
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SavePreparedInlineMessage;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'user_id'             => $this->userId,
                'result'              => $this->result->format(),
                'allow_user_chats'    => $this->allowUserChats,
                'allow_bot_chats'     => $this->allowBotChats,
                'allow_group_chats'   => $this->allowGroupChats,
                'allow_channel_chats' => $this->allowChannelChats,
            ]
        );
    }
}
