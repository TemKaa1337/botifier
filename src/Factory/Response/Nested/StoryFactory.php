<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Story;

final readonly class StoryFactory
{
    public function __construct(private ChatFactory $chatFactory) {}

    public function create(array $message): Story
    {
        return new Story(
            $this->chatFactory->create($message['chat']),
            $message['id']
        );
    }
}
