<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */

namespace Horde\Nls\Geoip;

/**
 * Contract for IP-to-country lookup providers.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
interface GeoipInterface
{
    /**
     * Returns country info for an IP address or hostname.
     *
     * @param string $host IP address or hostname
     *
     * @return array{code: string, name: string}|null Country info or null if not found
     */
    public function getCountryInfo(string $host): ?array;
}
