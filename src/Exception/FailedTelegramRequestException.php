<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Exception;

use RuntimeException;
use Temkaa\Botifier\Interface\ResponseInterface;

final class FailedTelegramRequestException extends RuntimeException implements BotifierExceptionInterface
{
    public function __construct(string $message, private readonly ResponseInterface $response)
    {
        parent::__construct($message);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
