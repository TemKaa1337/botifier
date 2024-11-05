<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Model\ResponseInterface;

final readonly class SendDocumentResponse extends AbstractResponse implements ResponseInterface
{
    public function __construct(
        bool $success,
        ?string $description,
        ?int $errorCode,
        private Message|bool|null $result,
        array $raw,
    ) {
        parent::__construct($success, $description, $errorCode, $raw);
    }

    public function getResult(): Message|bool|null
    {
        return $this->result;
    }
}
