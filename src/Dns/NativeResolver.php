<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * Wraps PHP's built-in gethostbyaddr() for reverse DNS lookups. Returns null
 * if resolution fails (gethostbyaddr returns the IP unchanged on failure).
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package  Nls
 */

namespace Horde\Nls\Dns;

class NativeResolver implements ResolverInterface
{
    public function reverse(string $ip): ?string
    {
        $host = @gethostbyaddr($ip);

        if ($host === false || $host === $ip) {
            return null;
        }

        return $host;
    }
}
