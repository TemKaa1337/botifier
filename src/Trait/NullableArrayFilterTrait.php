<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Trait;

trait NullableArrayFilterTrait
{
    /**
     * @param array<string, mixed> $data
     */
    public function filter(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($value === null) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
