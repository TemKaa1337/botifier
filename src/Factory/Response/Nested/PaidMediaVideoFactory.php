<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\PaidMediaVideo;

final readonly class PaidMediaVideoFactory
{
    public function __construct(private VideoFactory $videoFactory) {}

    public function create(array $message): PaidMediaVideo
    {
        return new PaidMediaVideo(
            $message['type'],
            $this->videoFactory->create($message['video'])
        );
    }
}
