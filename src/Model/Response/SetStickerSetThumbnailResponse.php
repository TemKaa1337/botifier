<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Response;

use Temkaa\Botifier\Interface\ResponseInterface;
use Temkaa\Botifier\Model\Response\Nested\ResponseParameters;

final readonly class SetStickerSetThumbnailResponse implements ResponseInterface
{
    public function __construct(
        public bool $ok,
        public ?true $result = null,
        public ?string $description = null,
        public ?int $errorCode = null,
        public ?ResponseParameters $parameters = null
    ) {}
}
