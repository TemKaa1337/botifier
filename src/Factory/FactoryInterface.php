<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Factory;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Model\ResponseInterface;

/**
 * @api
 */
interface FactoryInterface
{
    public function create(array $message): ResponseInterface;

    public function supports(ApiMethod $method): bool;
}
