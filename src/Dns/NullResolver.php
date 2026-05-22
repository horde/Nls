<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * A no-op resolver that always returns null. Used as default when no DNS
 * resolution is needed.
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package  Nls
 */

namespace Horde\Nls\Dns;

class NullResolver implements ResolverInterface
{
    public function reverse(string $ip): ?string
    {
        return null;
    }
}
