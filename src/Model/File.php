<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Model;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;

/**
 * @api
 */
final readonly class File
{
    public static function from(string $path): self
    {
        return new self(new LazyOpenStream($path, mode: 'rb'));
    }

    public function __construct(
        private StreamInterface $file,
    ) {
    }

    public function getFile(): StreamInterface
    {
        return $this->file;
    }
}
