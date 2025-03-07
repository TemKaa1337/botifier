<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

use Temkaa\Botifier\Trait\ArrayFilterTrait;

final readonly class ForceReply
{
    use ArrayFilterTrait;

    public function __construct(
        public true $forceReply,
        public ?string $inputFieldPlaceholder = null,
        public ?bool $selective = null
    ) {}

    public function format(): array
    {
        return $this->filterNullable(
            [
                'force_reply'             => $this->forceReply,
                'input_field_placeholder' => $this->inputFieldPlaceholder,
                'selective'               => $this->selective,
            ]
        );
    }
}
