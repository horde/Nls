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
 * ISO-3166 Alpha-2 to Alpha-3 code mapping.
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
class Alpha3 implements IteratorAggregate, \ArrayAccess, Countable
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
            'AD' => 'AND',
            'AE' => 'ARE',
            'AF' => 'AFG',
            'AG' => 'ATG',
            'AI' => 'AIA',
            'AL' => 'ALB',
            'AM' => 'ARM',
            'AO' => 'AGO',
            'AQ' => 'ATA',
            'AR' => 'ARG',
            'AS' => 'ASM',
            'AT' => 'AUT',
            'AU' => 'AUS',
            'AW' => 'ABW',
            'AX' => 'ALA',
            'AZ' => 'AZE',
            'BA' => 'BIH',
            'BB' => 'BRB',
            'BD' => 'BGD',
            'BE' => 'BEL',
            'BF' => 'BFA',
            'BG' => 'BGR',
            'BH' => 'BHR',
            'BI' => 'BDI',
            'BJ' => 'BEN',
            'BL' => 'BLM',
            'BM' => 'BMU',
            'BN' => 'BRN',
            'BO' => 'BOL',
            'BR' => 'BRA',
            'BS' => 'BHS',
            'BT' => 'BTN',
            'BV' => 'BVT',
            'BW' => 'BWA',
            'BY' => 'BLR',
            'BZ' => 'BLZ',
            'CA' => 'CAN',
            'CC' => 'CCK',
            'CD' => 'COD',
            'CF' => 'CAF',
            'CG' => 'COG',
            'CH' => 'CHE',
            'CI' => 'CIV',
            'CK' => 'COK',
            'CL' => 'CHL',
            'CM' => 'CMR',
            'CN' => 'CHN',
            'CO' => 'COL',
            'CR' => 'CRI',
            'CU' => 'CUB',
            'CV' => 'CPV',
            'CX' => 'CXR',
            'CY' => 'CYP',
            'CZ' => 'CZE',
            'DE' => 'DEU',
            'DJ' => 'DJI',
            'DK' => 'DNK',
            'DM' => 'DMA',
            'DO' => 'DOM',
            'DZ' => 'DZA',
            'EC' => 'ECU',
            'EE' => 'EST',
            'EG' => 'EGY',
            'EH' => 'ESH',
            'ER' => 'ERI',
            'ES' => 'ESP',
            'ET' => 'ETH',
            'FI' => 'FIN',
            'FJ' => 'FJI',
            'FK' => 'FLK',
            'FM' => 'FSM',
            'FO' => 'FRO',
            'FR' => 'FRA',
            'GA' => 'GAB',
            'GB' => 'GBR',
            'GD' => 'GRD',
            'GE' => 'GEO',
            'GF' => 'GUF',
            'GG' => 'GGY',
            'GH' => 'GHA',
            'GI' => 'GIB',
            'GL' => 'GRL',
            'GM' => 'GMB',
            'GN' => 'GIN',
            'GP' => 'GLP',
            'GQ' => 'GNQ',
            'GR' => 'GRC',
            'GS' => 'SGS',
            'GT' => 'GTM',
            'GU' => 'GUM',
            'GW' => 'GNB',
            'GY' => 'GUY',
            'HK' => 'HKG',
            'HM' => 'HMD',
            'HN' => 'HND',
            'HR' => 'HRV',
            'HT' => 'HTI',
            'HU' => 'HUN',
            'ID' => 'IDN',
            'IE' => 'IRL',
            'IL' => 'ISR',
            'IM' => 'IMN',
            'IN' => 'IND',
            'IO' => 'IOT',
            'IQ' => 'IRQ',
            'IR' => 'IRN',
            'IS' => 'ISL',
            'IT' => 'ITA',
            'JE' => 'JEY',
            'JM' => 'JAM',
            'JO' => 'JOR',
            'JP' => 'JPN',
            'KE' => 'KEN',
            'KG' => 'KGZ',
            'KH' => 'KHM',
            'KI' => 'KIR',
            'KM' => 'COM',
            'KN' => 'KNA',
            'KP' => 'PRK',
            'KR' => 'KOR',
            'KW' => 'KWT',
            'KY' => 'CYM',
            'KZ' => 'KAZ',
            'LA' => 'LAO',
            'LB' => 'LBN',
            'LC' => 'LCA',
            'LI' => 'LIE',
            'LK' => 'LKA',
            'LR' => 'LBR',
            'LS' => 'LSO',
            'LT' => 'LTU',
            'LU' => 'LUX',
            'LV' => 'LVA',
            'LY' => 'LBY',
            'MA' => 'MAR',
            'MC' => 'MCO',
            'MD' => 'MDA',
            'ME' => 'MNE',
            'MF' => 'MAF',
            'MG' => 'MDG',
            'MH' => 'MHL',
            'MK' => 'MKD',
            'ML' => 'MLI',
            'MM' => 'MMR',
            'MN' => 'MNG',
            'MO' => 'MAC',
            'MP' => 'MNP',
            'MQ' => 'MTQ',
            'MR' => 'MRT',
            'MS' => 'MSR',
            'MT' => 'MLT',
            'MU' => 'MUS',
            'MV' => 'MDV',
            'MW' => 'MWI',
            'MX' => 'MEX',
            'MY' => 'MYS',
            'MZ' => 'MOZ',
            'NA' => 'NAM',
            'NC' => 'NCL',
            'NE' => 'NER',
            'NF' => 'NFK',
            'NG' => 'NGA',
            'NI' => 'NIC',
            'NL' => 'NLD',
            'NO' => 'NOR',
            'NP' => 'NPL',
            'NR' => 'NRU',
            'NU' => 'NIU',
            'NZ' => 'NZL',
            'OM' => 'OMN',
            'PA' => 'PAN',
            'PE' => 'PER',
            'PF' => 'PYF',
            'PG' => 'PNG',
            'PH' => 'PHL',
            'PK' => 'PAK',
            'PL' => 'POL',
            'PM' => 'SPM',
            'PN' => 'PCN',
            'PR' => 'PRI',
            'PS' => 'PSE',
            'PT' => 'PRT',
            'PW' => 'PLW',
            'PY' => 'PRY',
            'QA' => 'QAT',
            'RE' => 'REU',
            'RO' => 'ROU',
            'RS' => 'SRB',
            'RU' => 'RUS',
            'RW' => 'RWA',
            'SA' => 'SAU',
            'SB' => 'SLB',
            'SC' => 'SYC',
            'SD' => 'SDN',
            'SE' => 'SWE',
            'SG' => 'SGP',
            'SH' => 'SHN',
            'SI' => 'SVN',
            'SJ' => 'SJM',
            'SK' => 'SVK',
            'SL' => 'SLE',
            'SM' => 'SMR',
            'SN' => 'SEN',
            'SO' => 'SOM',
            'SR' => 'SUR',
            'SS' => 'SSD',
            'ST' => 'STP',
            'SV' => 'SLV',
            'SY' => 'SYR',
            'SZ' => 'SWZ',
            'TC' => 'TCA',
            'TD' => 'TCD',
            'TF' => 'ATF',
            'TG' => 'TGO',
            'TH' => 'THA',
            'TJ' => 'TJK',
            'TK' => 'TKL',
            'TL' => 'TLS',
            'TM' => 'TKM',
            'TN' => 'TUN',
            'TO' => 'TON',
            'TR' => 'TUR',
            'TT' => 'TTO',
            'TV' => 'TUV',
            'TW' => 'TWN',
            'TZ' => 'TZA',
            'UA' => 'UKR',
            'UG' => 'UGA',
            'UM' => 'UMI',
            'US' => 'USA',
            'UY' => 'URY',
            'UZ' => 'UZB',
            'VA' => 'VAT',
            'VC' => 'VCT',
            'VE' => 'VEN',
            'VG' => 'VGB',
            'VI' => 'VIR',
            'VN' => 'VNM',
            'VU' => 'VUT',
            'WF' => 'WLF',
            'WS' => 'WSM',
            'YE' => 'YEM',
            'YT' => 'MYT',
            'ZA' => 'ZAF',
            'ZM' => 'ZMB',
            'ZW' => 'ZWE',
        ];
        }

        return $this->data;
    }

    /**
     * Lookup a single entry by code.
     */
    public function get(string $code): ?string
    {
        return $this->all()[strtoupper($code)] ?? null;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->all()[strtoupper((string) $offset)]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get((string) $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Alpha3 is read-only.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Alpha3 is read-only.');
    }

    public function count(): int
    {
        return count($this->all());
    }
}
