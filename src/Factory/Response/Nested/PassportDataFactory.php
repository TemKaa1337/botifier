<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory\Response\Nested;

use Temkaa\Botifier\Model\Response\Nested\EncryptedPassportElement;
use Temkaa\Botifier\Model\Response\Nested\PassportData;

final readonly class PassportDataFactory
{
    public function __construct(
        private EncryptedPassportElementFactory $encryptedPassportElementFactory,
        private EncryptedCredentialsFactory $encryptedCredentialsFactory
    ) {}

    public function create(array $message): PassportData
    {
        return new PassportData(
            array_map(fn (array $nested): EncryptedPassportElement => $this->encryptedPassportElementFactory->create($nested), $message['data']),
            $this->encryptedCredentialsFactory->create($message['credentials'])
        );
    }
}
