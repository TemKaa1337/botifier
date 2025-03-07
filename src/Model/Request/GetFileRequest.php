<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\GetFileResponse;

/**
 * @api
 *
 * @implements RequestInterface<GetFileResponse>
 */
final readonly class GetFileRequest implements RequestInterface
{
    public function __construct(public string $fileId) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::GetFile;
    }

    public function getData(): array
    {
        return [
            'file_id' => $this->fileId,
        ];
    }
}
