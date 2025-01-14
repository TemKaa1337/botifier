<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use DateTimeImmutable;
use DateTimeZone;
use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendPollResponse;
use Temkaa\Botifier\Model\Shared\ForceReply;
use Temkaa\Botifier\Model\Shared\InlineKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\InputPollOption;
use Temkaa\Botifier\Model\Shared\MessageEntity;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardMarkup;
use Temkaa\Botifier\Model\Shared\ReplyKeyboardRemove;
use Temkaa\Botifier\Model\Shared\ReplyParameters;
use Temkaa\Botifier\Trait\ArrayFilterTrait;

/**
 * @api
 *
 * @implements RequestInterface<SendPollResponse>
 */
final readonly class SendPollRequest implements RequestInterface
{
    use ArrayFilterTrait;

    /**
     * @param InputPollOption[]    $options
     * @param MessageEntity[]|null $questionEntities
     * @param MessageEntity[]|null $explanationEntities
     */
    public function __construct(
        public int|string $chatId,
        public string $question,
        public array $options,
        public ?string $businessConnectionId = null,
        public ?int $messageThreadId = null,
        public ?string $questionParseMode = null,
        public ?array $questionEntities = null,
        public ?bool $isAnonymous = null,
        public ?string $type = null,
        public ?bool $allowsMultipleAnswers = null,
        public ?int $correctOptionId = null,
        public ?string $explanation = null,
        public ?string $explanationParseMode = null,
        public ?array $explanationEntities = null,
        public ?int $openPeriod = null,
        public ?DateTimeImmutable $closeDate = null,
        public ?bool $isClosed = null,
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
        return ApiMethod::SendPoll;
    }

    public function getData(): array
    {
        return $this->filterNullable(
            [
                'chat_id'                 => $this->chatId,
                'question'                => $this->question,
                'options'                 => array_map(
                    static fn (InputPollOption $type): array => $type->format(),
                    $this->options
                ),
                'business_connection_id'  => $this->businessConnectionId,
                'message_thread_id'       => $this->messageThreadId,
                'question_parse_mode'     => $this->questionParseMode,
                'question_entities'       => $this->questionEntities === null
                    ? null
                    : array_map(
                        static fn (MessageEntity $type): array => $type->format(),
                        $this->questionEntities
                    ),
                'is_anonymous'            => $this->isAnonymous,
                'type'                    => $this->type,
                'allows_multiple_answers' => $this->allowsMultipleAnswers,
                'correct_option_id'       => $this->correctOptionId,
                'explanation'             => $this->explanation,
                'explanation_parse_mode'  => $this->explanationParseMode,
                'explanation_entities'    => $this->explanationEntities === null
                    ? null
                    : array_map(
                        static fn (MessageEntity $type): array => $type->format(),
                        $this->explanationEntities
                    ),
                'open_period'             => $this->openPeriod,
                'close_date'              => $this->closeDate?->setTimezone(new DateTimeZone('UTC'))?->getTimestamp() ?: null,
                'is_closed'               => $this->isClosed,
                'disable_notification'    => $this->disableNotification,
                'protect_content'         => $this->protectContent,
                'allow_paid_broadcast'    => $this->allowPaidBroadcast,
                'message_effect_id'       => $this->messageEffectId,
                'reply_parameters'        => $this->replyParameters?->format() ?: null,
                'reply_markup'            => $this->replyMarkup?->format() ?: null,
            ]
        );
    }
}
