<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Gift;
use Temkaa\Botifier\Model\Response\Nested\Gifts;

final readonly class GiftsFactory
{
    public function __construct(private GiftFactory $giftFactory) {}

    public function create(array $message): Gifts
    {
        return new Gifts(
            array_map(fn (array $nested): Gift => $this->giftFactory->create($nested), $message['gifts'])
        );
    }
}
