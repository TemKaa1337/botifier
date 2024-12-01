<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Interface\RequestInterface;
use Temkaa\Botifier\Model\Response\UploadStickerFileResponse;
use Temkaa\Botifier\Model\Shared\InputFile;

/**
 * @api
 *
 * @implements RequestInterface<UploadStickerFileResponse>
 */
final readonly class UploadStickerFileRequest implements RequestInterface
{
    public function __construct(
        public int $userId,
        public InputFile $sticker,
        public string $stickerFormat
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::UploadStickerFile;
    }

    public function getData(): array
    {
        return [
            'user_id'        => $this->userId,
            'sticker'        => $this->sticker->format(),
            'sticker_format' => $this->stickerFormat,
        ];
    }
}
