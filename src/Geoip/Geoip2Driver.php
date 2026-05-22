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

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

/**
 * GeoIP2/GeoLite2 MMDB adapter.
 *
 * Requires geoip2/geoip2 package.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
class Geoip2Driver implements GeoipInterface
{
    private readonly Reader $reader;

    /**
     * @param string $databasePath Path to the .mmdb database file
     */
    public function __construct(string $databasePath)
    {
        $this->reader = new Reader($databasePath);
    }

    public function getCountryInfo(string $host): ?array
    {
        $ip = $this->resolveToIp($host);
        if ($ip === null) {
            return null;
        }

        try {
            $record = $this->reader->country($ip);
            $code = $record->country->isoCode;
            $name = $record->country->name;

            if ($code === null || $name === null) {
                return null;
            }

            return [
                'code' => strtolower($code),
                'name' => $name,
            ];
        } catch (AddressNotFoundException) {
            return null;
        } catch (\Exception) {
            return null;
        }
    }

    private function resolveToIp(string $host): ?string
    {
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $host;
        }

        $ip = gethostbyname($host);
        if ($ip === $host) {
            return null;
        }

        return $ip;
    }
}
