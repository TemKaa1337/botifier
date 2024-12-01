<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\PaidMediaPhoto;
use Temkaa\Botifier\Model\Response\Nested\PhotoSize;

final readonly class PaidMediaPhotoFactory
{
    public function __construct(private PhotoSizeFactory $photoSizeFactory) {}

    public function create(array $message): PaidMediaPhoto
    {
        return new PaidMediaPhoto(
            $message['type'],
            array_map(fn (array $nested): PhotoSize => $this->photoSizeFactory->create($nested), $message['photo'])
        );
    }
}
