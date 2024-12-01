<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\TransactionPartnerTelegramApi;

final readonly class TransactionPartnerTelegramApiFactory
{
    public function create(array $message): TransactionPartnerTelegramApi
    {
        return new TransactionPartnerTelegramApi(
            $message['type'],
            $message['request_count']
        );
    }
}
