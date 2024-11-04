<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use SplFileInfo;
use Temkaa\Botifier\Exception\NotFoundException;

/**
 * @api
 */
final readonly class File
{
    public static function fromContent(string $content): self
    {
        return new self(content: $content);
    }

    public static function fromFile(string $path): self
    {
        if (!file_exists($path)) {
            throw new NotFoundException(sprintf('Could not find file at path: "%s".', $path));
        }

        return new self(path: $path);
    }

    /** @noinspection PhpMixedReturnTypeCanBeReducedInspection */
    public function getContent(): mixed
    {
        return $this->path !== null ? fopen($this->path, 'rb') : $this->content;
    }

    public function getFileName(): ?string
    {
        if ($this->path === null) {
            return null;
        }

        return (new SplFileInfo($this->path))->getFilename();
    }

    private function __construct(
        private ?string $path = null,
        private ?string $content = null,
    ) {
    }
}
