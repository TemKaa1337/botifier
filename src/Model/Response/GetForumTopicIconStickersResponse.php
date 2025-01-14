<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;
use Temkaa\Botifier\Model\Response\Nested\Sticker;
use Temkaa\Botifier\Model\ResponseInterface;

final readonly class GetForumTopicIconStickersResponse implements ResponseInterface
{
    /**
     * @param Sticker[]|null $result
     */
    public function __construct(
        public bool $ok,
        public ?array $result = null,
        public ?string $description = null,
        public ?int $errorCode = null,
        public ?ResponseParameters $parameters = null
    ) {}
}
