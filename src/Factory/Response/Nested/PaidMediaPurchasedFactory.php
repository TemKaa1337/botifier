<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Factory\Shared\UserFactory;
use Temkaa\Botifier\Model\Response\Nested\PaidMediaPurchased;

final readonly class PaidMediaPurchasedFactory
{
    public function __construct(private UserFactory $userFactory) {}

    public function create(array $message): PaidMediaPurchased
    {
        return new PaidMediaPurchased(
            $this->userFactory->create($message['from']),
            $message['paid_media_payload']
        );
    }
}
