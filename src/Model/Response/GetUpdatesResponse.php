<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetUpdatesResponse extends AbstractResponse implements ResponseInterface
{
    public function __construct(
        bool $success,
        ?string $description,
        ?int $errorCode,
        /**
         * @var Message[]|bool|null $result
         */
        private array|bool|null $result,
        array $raw,
    ) {
        parent::__construct($success, $description, $errorCode, $raw);
    }

    /**
     * @return Message[]|bool|null
     */
    public function getResult(): array|bool|null
    {
        return $this->result;
    }
}
