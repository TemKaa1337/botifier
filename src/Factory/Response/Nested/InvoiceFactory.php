<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\Invoice;

final readonly class InvoiceFactory
{
    public function create(array $message): Invoice
    {
        return new Invoice(
            $message['title'],
            $message['description'],
            $message['start_parameter'],
            $message['currency'],
            $message['total_amount']
        );
    }
}
