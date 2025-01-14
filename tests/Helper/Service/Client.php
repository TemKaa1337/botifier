<?php

declare(strict_types=1);

namespace Tests\Helper\Service;

use LogicException;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\Nested\Update;
use Temkaa\Botifier\Model\ResponseInterface;
use Temkaa\Botifier\Service\Telegram\ClientInterface;
use function array_shift;

final class Client implements ClientInterface
{
    /**
     * @var ResponseInterface[]
     */
    private static array $responses = [];

    public function reply(RequestInterface $request, Update $update): ResponseInterface
    {
        throw new LogicException('Not implemented');
    }

    public static function reset(): void
    {
        self::$responses = [];
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        return array_shift(self::$responses);
    }

    /**
     * @param ResponseInterface[] $responses
     */
    public static function setResponses(array $responses): void
    {
        self::$responses = $responses;
    }
}
