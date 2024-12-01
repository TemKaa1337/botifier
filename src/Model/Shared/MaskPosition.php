<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Shared;

final readonly class MaskPosition
{
    public function __construct(
        public string $point,
        public float $xShift,
        public float $yShift,
        public float $scale
    ) {}

    public function format(): array
    {
        return [
            'point'   => $this->point,
            'x_shift' => $this->xShift,
            'y_shift' => $this->yShift,
            'scale'   => $this->scale,
        ];
    }
}
