<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request\File;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\File;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SendDocumentResponse;

/**
 * @api
 *
 * @implements RequestInterface<SendDocumentResponse>
 */
final readonly class DocumentRequest implements RequestInterface
{
    // TODO: add tests on all of those
    public static function fromFile(int $chatId, File $file, ?string $text = null): self
    {
        return new self($chatId, $file, $text);
    }

    public static function fromFileId(int $chatId, string $fileId, ?string $text = null): self
    {
        return new self($chatId, $fileId, $text);
    }

    public static function fromUrl(int $chatId, string $url, ?string $text = null): self
    {
        return new self($chatId, $url, $text);
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SendDocument;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getParameters(): array
    {
        $data = ['chat_id' => $this->chatId, 'document' => $this->file];
        if ($this->text !== null) {
            $data['caption'] = $this->text;
        }

        return $data;
    }

    private function __construct(
        private int $chatId,
        private File|string $file,
        private ?string $text = null,
    ) {
    }
}
