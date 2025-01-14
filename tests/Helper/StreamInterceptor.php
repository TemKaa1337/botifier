<?php

declare(strict_types=1);

namespace Tests\Helper;

use php_user_filter;
use function stream_bucket_append;
use function stream_bucket_make_writeable;
use const PSFS_PASS_ON;

final class StreamInterceptor extends php_user_filter
{
    private static string $buffer = '';

    public static function getBuffer(): string
    {
        return self::$buffer;
    }

    public static function getFilterName(): string
    {
        return 'stdout_interceptor';
    }

    public static function reset(): void
    {
        self::$buffer = '';
    }

    public function filter(mixed $in, mixed $out, mixed &$consumed, bool $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$buffer .= $bucket->data;
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }
}
