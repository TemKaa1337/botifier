<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\GameHighScore;

final readonly class GameHighScoreFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): GameHighScore
    {
        return new GameHighScore(
            $message['position'],
            $this->userFactory->create($message['user']),
            $message['score']
        );
    }
}
