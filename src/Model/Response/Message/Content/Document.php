<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message\Content;

use Temkaa\Botifier\Enum\Message\Content\Type;
use Temkaa\Botifier\Model\Response\Message\Content\Document\Thumb;
use Temkaa\Botifier\Model\Response\Message\ContentInterface;

final readonly class Document implements ContentInterface
{
    public function __construct(
        private string $fileName,
        private string $mimeType,
        private ?Thumb $thumbNail,
        private ?Thumb $thumb,
        private string $fileId,
        private string $fileUniqueId,
        private int $fileSize,
    ) {
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getThumb(): ?Thumb
    {
        return $this->thumb;
    }

    public function getThumbNail(): ?Thumb
    {
        return $this->thumbNail;
    }

    public function getType(): Type
    {
        return Type::Document;
    }
}
