<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model\CurrentConversation;

use InvalidArgumentException;
use JsonSerializable;
use function sprintf;

// TODO: make it array access?
final class Context implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return $this->map;
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
