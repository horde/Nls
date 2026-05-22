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

namespace Horde\Nls;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use LogicException;

/**
 * International license plate prefix codes.
 *
 * Provides array-like read-only access. Translation is an explicit action
 * via the translated() method.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 *
 * @implements IteratorAggregate<string, string>
 */
class Carsigns implements IteratorAggregate, \ArrayAccess, Countable
{
    private ?array $data = null;

    /**
     * Returns all data entries (English).
     *
     * @return array<string, string>
     */
    public function all(): array
    {
        if ($this->data === null) {
            $this->data = [
            'at' => 'A',
            'af' => 'AFG',
            'ag' => 'AG',
            'al' => 'AL',
            'ad' => 'AND',
            'ao' => 'ANG',
            'am' => 'ARM',
            'au' => 'AUS',
            'az' => 'AZ',
            'be' => 'B',
            'bd' => 'BD',
            'bb' => 'BDS',
            'bf' => 'BF',
            'bg' => 'BG',
            'bz' => 'BZ',
            'bt' => 'BHT',
            'ba' => 'BIH',
            'bo' => 'BOL',
            'br' => 'BR',
            'bh' => 'BRN',
            'bn' => 'BRU',
            'bs' => 'BS',
            'bi' => 'BU',
            'vg' => 'BVI',
            'by' => 'BY',
            'cu' => 'C',
            'cm' => 'CAM',
            'cd' => 'RCB',
            'ca' => 'CDN',
            'ch' => 'CH',
            'ci' => 'CI',
            'lk' => 'CL',
            'co' => 'CO',
            'km' => 'COM',
            'cr' => 'CR',
            'cv' => 'CV',
            'cy' => 'CY',
            'cz' => 'CZ',
            'de' => 'D',
            'dj' => 'DJI',
            'dk' => 'DK',
            'do' => 'DOM',
            'kp' => 'DVRK',
            'bj' => 'DY',
            'dz' => 'DZ',
            'es' => 'E',
            'ke' => 'EAK',
            'tz' => 'EAT',
            'ug' => 'EAU',
            'ec' => 'EC',
            'er' => 'ER',
            'sv' => 'ES',
            'ee' => 'EST',
            'eg' => 'ET',
            'et' => 'ETH',
            'fr' => 'F',
            'fi' => 'FIN',
            'fj' => 'FJI',
            'li' => 'FL',
            'fo' => 'FO',
            'fm' => 'FSM',
            'ga' => 'G',
            'gb' => 'GB',
            'gi' => 'GBZ',
            'gt' => 'GCA',
            'ge' => 'GE',
            'gh' => 'GH',
            'gq' => 'GQ',
            'gr' => 'GR',
            'gy' => 'GUY',
            'hu' => 'H',
            'hk' => 'HK',
            'hn' => 'HN',
            'hr' => 'HR',
            'it' => 'I',
            'il' => 'IL',
            'in' => 'IND',
            'ir' => 'IR',
            'ie' => 'IRL',
            'iq' => 'IRQ',
            'is' => 'IS',
            'jp' => 'J',
            'jm' => 'JA',
            'jo' => 'JOR',
            'kh' => 'K',
            'ki' => 'KIR',
            'gl' => 'KN',
            'kg' => 'KS',
            'sa' => 'KSA',
            'kw' => 'KWT',
            'kz' => 'KZ',
            'lu' => 'L',
            'la' => 'LAO',
            'ly' => 'LAR',
            'lr' => 'LB',
            'ls' => 'LS',
            'lt' => 'LT',
            'lv' => 'LV',
            'mt' => 'M',
            'ma' => 'MA',
            'my' => 'MAL',
            'mc' => 'MC',
            'md' => 'MD',
            'mx' => 'MEX',
            'mn' => 'MGL',
            'mh' => 'MH',
            'mk' => 'MK',
            'mz' => 'MOC',
            'mu' => 'MS',
            'mv' => 'MV',
            'mw' => 'MW',
            'mm' => 'MYA',
            'no' => 'N',
            'an' => 'NA',
            'nl' => 'NL',
            'nz' => 'NZ',
            'om' => 'OM',
            'pt' => 'P',
            'pa' => 'PA',
            'pw' => 'PAL',
            'pe' => 'PE',
            'pk' => 'PK',
            'pl' => 'PL',
            'pg' => 'PNG',
            'cn' => 'PRC',
            'ps' => 'PS',
            'py' => 'PY',
            'qa' => 'Q',
            'ar' => 'RA',
            'bw' => 'RB',
            'tw' => 'RC',
            'cf' => 'RCA',
            'cl' => 'RCH',
            're' => 'RE',
            'gn' => 'RG',
            'ht' => 'RH',
            'id' => 'RI',
            'mr' => 'RIM',
            'lb' => 'RL',
            'mg' => 'RM',
            'ml' => 'RMM',
            'ne' => 'RN',
            'ro' => 'RO',
            'kr' => 'ROK',
            'uy' => 'ROU',
            'ph' => 'RP',
            'sm' => 'RSM',
            'tg' => 'RT',
            'ru' => 'RUS',
            'rw' => 'RWA',
            'se' => 'S',
            'cs' => 'SCG',
            'kn' => 'SCN',
            'sz' => 'SD',
            'sg' => 'SGP',
            'sk' => 'SK',
            'si' => 'SLO',
            'sr' => 'SME',
            'sn' => 'SN',
            'sb' => 'SOL',
            'so' => 'SP',
            'st' => 'STP',
            'sd' => 'SUD',
            'sc' => 'SY',
            'sy' => 'SYR',
            'td' => 'TCH',
            'th' => 'THA',
            'tj' => 'TJ',
            'tl' => 'TL',
            'tm' => 'TM',
            'tn' => 'TN',
            'to' => 'TO',
            'tr' => 'TR',
            'tt' => 'TT',
            'tv' => 'TUV',
            'ua' => 'UA',
            'ae' => 'UAE',
            'us' => 'USA',
            'uz' => 'UZ',
            'va' => 'V',
            'vn' => 'VN',
            'vu' => 'VU',
            'GM' => 'WAG',
            'sl' => 'WAL',
            'ng' => 'WAN',
            'dm' => 'WD',
            'gd' => 'WG',
            'lc' => 'WL',
            'ws' => 'WS',
            'vc' => 'WV',
            'ye' => 'YAR',
            've' => 'YV',
            'zm' => 'Z',
            'za' => 'ZA',
            'zw' => 'ZW',
        ];
        }

        return $this->data;
    }

    /**
     * Lookup a single entry by code.
     */
    public function get(string $code): ?string
    {
        return $this->all()[strtolower($code)] ?? null;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->all()[strtolower((string) $offset)]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get((string) $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Carsigns is read-only.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Carsigns is read-only.');
    }

    public function count(): int
    {
        return count($this->all());
    }
}
