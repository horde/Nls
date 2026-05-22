<?php

declare(strict_types=1);

/**
 * Horde optimized interface to the MaxMind legacy IP Address->Country database.
 *
 * Based on PHP geoip.inc library by MaxMind LLC:
 *   http://www.maxmind.com/download/geoip/api/php/
 *
 * Copyright 2003-2026 MaxMind LLC
 * Copyright 2003-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */

namespace Horde\Nls\Geoip;

use Horde\Nls\Countries;

/**
 * MaxMind legacy .dat binary database reader.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
class LegacyDatDriver implements GeoipInterface
{
    private const GEOIP_COUNTRY_BEGIN = 16776960;
    private const STRUCTURE_INFO_MAX_SIZE = 20;
    private const STANDARD_RECORD_LENGTH = 3;

    private const COUNTRY_CODES = [
        '', 'AP', 'EU', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AN', 'AO',
        'AQ', 'AR', 'AS', 'AT', 'AU', 'AW', 'AZ', 'BA', 'BB', 'BD', 'BE',
        'BF', 'BG', 'BH', 'BI', 'BJ', 'BM', 'BN', 'BO', 'BR', 'BS', 'BT',
        'BV', 'BW', 'BY', 'BZ', 'CA', 'CC', 'CD', 'CF', 'CG', 'CH', 'CI',
        'CK', 'CL', 'CM', 'CN', 'CO', 'CR', 'CU', 'CV', 'CX', 'CY', 'CZ',
        'DE', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EC', 'EE', 'EG', 'EH', 'ER',
        'ES', 'ET', 'FI', 'FJ', 'FK', 'FM', 'FO', 'FR', 'FX', 'GA', 'GB',
        'GD', 'GE', 'GF', 'GH', 'GI', 'GL', 'GM', 'GN', 'GP', 'GQ', 'GR',
        'GS', 'GT', 'GU', 'GW', 'GY', 'HK', 'HM', 'HN', 'HR', 'HT', 'HU',
        'ID', 'IE', 'IL', 'IN', 'IO', 'IQ', 'IR', 'IS', 'IT', 'JM', 'JO',
        'JP', 'KE', 'KG', 'KH', 'KI', 'KM', 'KN', 'KP', 'KR', 'KW', 'KY',
        'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU', 'LV',
        'LY', 'MA', 'MC', 'MD', 'MG', 'MH', 'MK', 'ML', 'MM', 'MN', 'MO',
        'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ',
        'NA', 'NC', 'NE', 'NF', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU',
        'NZ', 'OM', 'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN',
        'PR', 'PS', 'PT', 'PW', 'PY', 'QA', 'RE', 'RO', 'RU', 'RW', 'SA',
        'SB', 'SC', 'SD', 'SE', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM',
        'SN', 'SO', 'SR', 'ST', 'SV', 'SY', 'SZ', 'TC', 'TD', 'TF', 'TG',
        'TH', 'TJ', 'TK', 'TM', 'TN', 'TO', 'TL', 'TR', 'TT', 'TV', 'TW',
        'TZ', 'UA', 'UG', 'UM', 'US', 'UY', 'UZ', 'VA', 'VC', 'VE', 'VG',
        'VI', 'VN', 'VU', 'WF', 'WS', 'YE', 'YT', 'RS', 'ZA', 'ZM', 'CD',
        'ZW', 'A1', 'A2', 'O1',
    ];

    /** @var resource|null */
    private $fh = null;

    private readonly Countries $countries;

    public function __construct(
        private readonly string $datafile,
        ?Countries $countries = null,
    ) {
        $this->countries = $countries ?? new Countries();
    }

    public function getCountryInfo(string $host): ?array
    {
        $ip = $this->resolveToIp($host);
        if ($ip === null) {
            return null;
        }

        $id = $this->countryIdByAddr($ip);
        if ($id === null || $id <= 0) {
            return null;
        }

        $code = self::COUNTRY_CODES[$id] ?? null;
        if ($code === null || $code === '') {
            return null;
        }

        $name = $this->countries->get($code) ?? $code;

        return [
            'code' => strtolower($code),
            'name' => $name,
        ];
    }

    private function resolveToIp(string $host): ?string
    {
        if (filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $host;
        }

        $ip = gethostbyname($host);
        if ($ip === $host) {
            return null;
        }

        return $ip;
    }

    private function countryIdByAddr(string $addr): ?int
    {
        if (!$this->open()) {
            return null;
        }

        $ipnum = ip2long($addr);
        if ($ipnum === false) {
            return null;
        }

        $result = $this->seekCountry($ipnum);
        if ($result === null) {
            return null;
        }

        return $result - self::GEOIP_COUNTRY_BEGIN;
    }

    private function open(): bool
    {
        if ($this->fh !== null) {
            return true;
        }

        if ($this->datafile === '' || !is_file($this->datafile)) {
            return false;
        }

        $fh = fopen($this->datafile, 'rb');
        if ($fh === false) {
            return false;
        }

        $this->fh = $fh;

        $filepos = ftell($this->fh);
        fseek($this->fh, -3, SEEK_END);

        for ($i = 0; $i < self::STRUCTURE_INFO_MAX_SIZE; ++$i) {
            $delim = fread($this->fh, 3);
            if ($delim === (chr(255) . chr(255) . chr(255))) {
                break;
            }
            fseek($this->fh, -4, SEEK_CUR);
        }

        fseek($this->fh, $filepos, SEEK_SET);

        return true;
    }

    private function seekCountry(int $ipnum): ?int
    {
        $offset = 0;

        for ($depth = 31; $depth >= 0; --$depth) {
            $seekPos = 2 * self::STANDARD_RECORD_LENGTH * $offset;
            if (fseek($this->fh, $seekPos, SEEK_SET) !== 0) {
                return null;
            }

            $buf = fread($this->fh, 2 * self::STANDARD_RECORD_LENGTH);
            if ($buf === false || strlen($buf) < 2 * self::STANDARD_RECORD_LENGTH) {
                return null;
            }

            $x = [0, 0];
            for ($i = 0; $i < 2; ++$i) {
                for ($j = 0; $j < self::STANDARD_RECORD_LENGTH; ++$j) {
                    $x[$i] += ord($buf[self::STANDARD_RECORD_LENGTH * $i + $j]) << ($j * 8);
                }
            }

            if ($ipnum & (1 << $depth)) {
                if ($x[1] >= self::GEOIP_COUNTRY_BEGIN) {
                    return $x[1];
                }
                $offset = $x[1];
            } else {
                if ($x[0] >= self::GEOIP_COUNTRY_BEGIN) {
                    return $x[0];
                }
                $offset = $x[0];
            }
        }

        return null;
    }

    public function __destruct()
    {
        if ($this->fh !== null) {
            fclose($this->fh);
            $this->fh = null;
        }
    }
}
