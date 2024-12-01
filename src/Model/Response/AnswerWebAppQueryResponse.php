<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;
use Temkaa\Botifier\Model\Response\Nested\SentWebAppMessage;

final readonly class AnswerWebAppQueryResponse implements ResponseInterface
{
    public function __construct(
        public bool $ok,
        public ?SentWebAppMessage $result = null,
        public ?string $description = null,
        public ?int $errorCode = null,
        public ?ResponseParameters $parameters = null
    ) {}
}
