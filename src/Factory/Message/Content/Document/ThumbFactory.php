<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Message\Content\Document;

use Temkaa\Botifier\Model\Response\Message\Content\Document\Thumb;

final readonly class ThumbFactory
{
    public function create(array $data): Thumb
    {
        return new Thumb(
            $data['file_id'],
            $data['file_unique_id'],
            $data['file_size'],
            $data['width'],
            $data['height'],
        );
    }
}
