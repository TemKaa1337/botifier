<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response\Message\Content\Document;

final readonly class Thumb
{
    public function __construct(
        private string $fileId,
        private string $fileUniqueId,
        private int $fileSize,
        private int $width,
        private int $height,
    ) {
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
