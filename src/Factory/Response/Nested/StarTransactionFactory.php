<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Temkaa\Botifier\Model\Response\Nested\StarTransaction;

final readonly class StarTransactionFactory
{
    public function __construct(
        private TransactionPartnerUserFactory $transactionPartnerUserFactory,
        private TransactionPartnerFragmentFactory $transactionPartnerFragmentFactory,
        private TransactionPartnerTelegramAdsFactory $transactionPartnerTelegramAdsFactory,
        private TransactionPartnerTelegramApiFactory $transactionPartnerTelegramApiFactory,
        private TransactionPartnerOtherFactory $transactionPartnerOtherFactory
    ) {}

    public function create(array $message): StarTransaction
    {
        return new StarTransaction(
            $message['id'],
            $message['amount'],
            (new DateTimeImmutable())->setTimestamp($message['date'])->setTimezone(new DateTimeZone('UTC')),
            match (true) {
                !isset($message['source'])                    => null,
                $message['source']['type'] === 'user'         => $this->transactionPartnerUserFactory->create($message['source']),
                $message['source']['type'] === 'fragment'     => $this->transactionPartnerFragmentFactory->create($message['source']),
                $message['source']['type'] === 'telegram_ads' => $this->transactionPartnerTelegramAdsFactory->create($message['source']),
                $message['source']['type'] === 'telegram_api' => $this->transactionPartnerTelegramApiFactory->create($message['source']),
                $message['source']['type'] === 'other'        => $this->transactionPartnerOtherFactory->create($message['source']),
                default                                       => throw new InvalidArgumentException('Could not find factory for message.')
            },
            match (true) {
                !isset($message['receiver'])                    => null,
                $message['receiver']['type'] === 'user'         => $this->transactionPartnerUserFactory->create($message['receiver']),
                $message['receiver']['type'] === 'fragment'     => $this->transactionPartnerFragmentFactory->create($message['receiver']),
                $message['receiver']['type'] === 'telegram_ads' => $this->transactionPartnerTelegramAdsFactory->create($message['receiver']),
                $message['receiver']['type'] === 'telegram_api' => $this->transactionPartnerTelegramApiFactory->create($message['receiver']),
                $message['receiver']['type'] === 'other'        => $this->transactionPartnerOtherFactory->create($message['receiver']),
                default                                         => throw new InvalidArgumentException('Could not find factory for message.')
            }
        );
    }
}
