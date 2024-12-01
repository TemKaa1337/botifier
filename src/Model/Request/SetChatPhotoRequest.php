<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\SetChatPhotoResponse;
use Temkaa\Botifier\Model\Shared\InputFile;

/**
 * @api
 *
 * @implements RequestInterface<SetChatPhotoResponse>
 */
final readonly class SetChatPhotoRequest implements RequestInterface
{
    public function __construct(
        public int|string $chatId,
        public InputFile $photo
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetChatPhoto;
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'photo'   => $this->photo->format(),
        ];
    }
}
