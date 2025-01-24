<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\CurrentConversation;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;
use function sprintf;

/**
 * @template-implements ArrayAccess<string, mixed>
 */
final class Context implements ArrayAccess, JsonSerializable
{
    /**
     * @param array<string, mixed> $map
     */
    public function __construct(
        private array $map = [],
    ) {
    }

    public function get(string $key): mixed
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(sprintf('Key "%s" does not exist in context.', $key));
        }

        return $this->map[$key];
    }

    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->map;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->map[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->map[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->map[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->map[$offset]);
    }

    public function set(string $key, mixed $value): self
    {
        $this->map[$key] = $value;

        return $this;
    }

    public function unset(string $key): self
    {
        if ($this->has($key)) {
            unset($this->map[$key]);
        }

        return $this;
    }
}
