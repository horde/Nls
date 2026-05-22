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
 * Top-level domain to country mapping.
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
class Tld implements IteratorAggregate, \ArrayAccess, Countable
{
    private ?array $data = null;

    private ?array $translated = null;

    /**
     * Returns all data entries (English).
     *
     * @return array<string, string>
     */
    public function all(): array
    {
        if ($this->data === null) {
            $this->data = [
            'ac' => 'Ascension Island',
            'ad' => 'Andorra',
            'ae' => 'United Arab Emirates',
            'af' => 'Afghanistan',
            'ag' => 'Antigua and Barbuda',
            'ai' => 'Anguilla',
            'al' => 'Albania',
            'am' => 'Armenia',
            'ao' => 'Angola',
            'aq' => 'Antarctica',
            'ar' => 'Argentina',
            'as' => 'American Samoa',
            'at' => 'Austria',
            'au' => 'Australia',
            'aw' => 'Aruba',
            'ax' => 'Aland Islands',
            'az' => 'Azerbaijan',
            'ba' => 'Bosnia and Herzegovina',
            'bb' => 'Barbados',
            'bd' => 'Bangladesh',
            'be' => 'Belgium',
            'bf' => 'Burkina Faso',
            'bg' => 'Bulgaria',
            'bh' => 'Bahrain',
            'bi' => 'Burundi',
            'bj' => 'Benin',
            'bm' => 'Bermuda',
            'bn' => 'Brunei Darussalam',
            'bo' => 'Bolivia',
            'br' => 'Brazil',
            'bs' => 'Bahamas',
            'bt' => 'Bhutan',
            'bv' => 'Bouvet Island',
            'bw' => 'Botswana',
            'by' => 'Belarus',
            'bz' => 'Belize',
            'ca' => 'Canada',
            'cc' => 'Cocos (Keeling) Islands',
            'cd' => 'Congo, The Democratic Republic of the',
            'cf' => 'Central African Republic',
            'cg' => 'Congo, Republic of',
            'ch' => 'Switzerland',
            'ci' => 'Cote d\'Ivoire',
            'ck' => 'Cook Islands',
            'cl' => 'Chile',
            'cm' => 'Cameroon',
            'cn' => 'China',
            'co' => 'Colombia',
            'cr' => 'Costa Rica',
            'cu' => 'Cuba',
            'cv' => 'Cape Verde',
            'cx' => 'Christmas Island',
            'cy' => 'Cyprus',
            'cz' => 'Czech Republic',
            'de' => 'Germany',
            'dj' => 'Djibouti',
            'dk' => 'Denmark',
            'dm' => 'Dominica',
            'do' => 'Dominican Republic',
            'dz' => 'Algeria',
            'ec' => 'Ecuador',
            'ee' => 'Estonia',
            'eg' => 'Egypt',
            'eh' => 'Western Sahara',
            'er' => 'Eritrea',
            'es' => 'Spain',
            'et' => 'Ethiopia',
            'eu' => 'European Union',
            'fi' => 'Finland',
            'fj' => 'Fiji',
            'fk' => 'Falkland Islands (Malvinas)',
            'fm' => 'Micronesia, Federated States of',
            'fo' => 'Faroe Islands',
            'fr' => 'France',
            'ga' => 'Gabon',
            'gb' => 'United Kingdom',
            'gd' => 'Grenada',
            'ge' => 'Georgia',
            'gf' => 'French Guiana',
            'gg' => 'Guernsey',
            'gh' => 'Ghana',
            'gi' => 'Gibraltar',
            'gl' => 'Greenland',
            'gm' => 'Gambia',
            'gn' => 'Guinea',
            'gp' => 'Guadeloupe',
            'gq' => 'Equatorial Guinea',
            'gr' => 'Greece',
            'gs' => 'South Georgia and the South Sandwich Islands',
            'gt' => 'Guatemala',
            'gu' => 'Guam',
            'gw' => 'Guinea-Bissau',
            'gy' => 'Guyana',
            'hk' => 'Hong Kong',
            'hm' => 'Heard and McDonald Islands',
            'hn' => 'Honduras',
            'hr' => 'Croatia/Hrvatska',
            'ht' => 'Haiti',
            'hu' => 'Hungary',
            'id' => 'Indonesia',
            'ie' => 'Ireland',
            'il' => 'Israel',
            'im' => 'Isle of Man',
            'in' => 'India',
            'io' => 'British Indian Ocean Territory',
            'iq' => 'Iraq',
            'ir' => 'Iran, Islamic Republic of',
            'is' => 'Iceland',
            'it' => 'Italy',
            'je' => 'Jersey',
            'jm' => 'Jamaica',
            'jo' => 'Jordan',
            'jp' => 'Japan',
            'ke' => 'Kenya',
            'kg' => 'Kyrgyzstan',
            'kh' => 'Cambodia',
            'ki' => 'Kiribati',
            'km' => 'Comoros',
            'kn' => 'Saint Kitts and Nevis',
            'kp' => 'Korea, Democratic People\'s Republic of',
            'kr' => 'Korea, Republic of',
            'kw' => 'Kuwait',
            'ky' => 'Cayman Islands',
            'kz' => 'Kazakhstan',
            'la' => 'Lao People\'s Democratic Republic',
            'lb' => 'Lebanon',
            'lc' => 'Saint Lucia',
            'li' => 'Liechtenstein',
            'lk' => 'Sri Lanka',
            'lr' => 'Liberia',
            'ls' => 'Lesotho',
            'lt' => 'Lithuania',
            'lu' => 'Luxembourg',
            'lv' => 'Latvia',
            'ly' => 'Libyan Arab Jamahiriya',
            'ma' => 'Morocco',
            'mc' => 'Monaco',
            'md' => 'Moldova, Republic of',
            'me' => 'Montenegro',
            'mg' => 'Madagascar',
            'mh' => 'Marshall Islands',
            'mk' => 'Macedonia, The Former Yugoslav Republic of',
            'ml' => 'Mali',
            'mm' => 'Myanmar',
            'mn' => 'Mongolia',
            'mo' => 'Macao',
            'mp' => 'Northern Mariana Islands',
            'mq' => 'Martinique',
            'mr' => 'Mauritania',
            'ms' => 'Montserrat',
            'mt' => 'Malta',
            'mu' => 'Mauritius',
            'mv' => 'Maldives',
            'mw' => 'Malawi',
            'mx' => 'Mexico',
            'my' => 'Malaysia',
            'mz' => 'Mozambique',
            'na' => 'Namibia',
            'nc' => 'New Caledonia',
            'ne' => 'Niger',
            'nf' => 'Norfolk Island',
            'ng' => 'Nigeria',
            'ni' => 'Nicaragua',
            'nl' => 'Netherlands',
            'no' => 'Norway',
            'np' => 'Nepal',
            'nr' => 'Nauru',
            'nu' => 'Niue',
            'nz' => 'New Zealand',
            'om' => 'Oman',
            'pa' => 'Panama',
            'pe' => 'Peru',
            'pf' => 'French Polynesia',
            'pg' => 'Papua New Guinea',
            'ph' => 'Philippines',
            'pk' => 'Pakistan',
            'pl' => 'Poland',
            'pm' => 'Saint Pierre and Miquelon',
            'pn' => 'Pitcairn Island',
            'pr' => 'Puerto Rico',
            'ps' => 'Palestinian Territory, Occupied',
            'pt' => 'Portugal',
            'pw' => 'Palau',
            'py' => 'Paraguay',
            'qa' => 'Qatar',
            're' => 'Reunion Island',
            'ro' => 'Romania',
            'rs' => 'Serbia',
            'ru' => 'Russian Federation',
            'rw' => 'Rwanda',
            'sa' => 'Saudi Arabia',
            'sb' => 'Solomon Islands',
            'sc' => 'Seychelles',
            'sd' => 'Sudan',
            'se' => 'Sweden',
            'sg' => 'Singapore',
            'sh' => 'Saint Helena',
            'si' => 'Slovenia',
            'sj' => 'Svalbard and Jan Mayen Islands',
            'sk' => 'Slovakia',
            'sl' => 'Sierra Leone',
            'sm' => 'San Marino',
            'sn' => 'Senegal',
            'so' => 'Somalia',
            'sr' => 'Suriname',
            'st' => 'Sao Tome and Principe',
            'su' => 'Soviet Union',
            'sv' => 'El Salvador',
            'sy' => 'Syrian Arab Republic',
            'sz' => 'Swaziland',
            'tc' => 'Turks and Caicos Islands',
            'td' => 'Chad',
            'tf' => 'French Southern Territories',
            'tg' => 'Togo',
            'th' => 'Thailand',
            'tj' => 'Tajikistan',
            'tk' => 'Tokelau',
            'tl' => 'Timor-Leste',
            'tm' => 'Turkmenistan',
            'tn' => 'Tunisia',
            'to' => 'Tonga',
            'tp' => 'East Timor',
            'tr' => 'Turkey',
            'tt' => 'Trinidad and Tobago',
            'tv' => 'Tuvalu',
            'tw' => 'Taiwan',
            'tz' => 'Tanzania, United Republic of',
            'ua' => 'Ukraine',
            'ug' => 'Uganda',
            'uk' => 'United Kingdom',
            'um' => 'United States Minor Outlying Islands',
            'us' => 'United States',
            'uy' => 'Uruguay',
            'uz' => 'Uzbekistan',
            'va' => 'Holy See (Vatican City State)',
            'vc' => 'Saint Vincent and the Grenadines',
            've' => 'Venezuela',
            'vg' => 'Virgin Islands, British',
            'vi' => 'Virgin Islands, U.S.',
            'vn' => 'Viet Nam',
            'vu' => 'Vanuatu',
            'wf' => 'Wallis and Futuna Islands',
            'ws' => 'Samoa',
            'ye' => 'Yemen',
            'yt' => 'Mayotte',
            'za' => 'South Africa',
            'zm' => 'Zambia',
            'zw' => 'Zimbabwe',
        ];
        }

        return $this->data;
    }

    /**
     * Returns translated data, sorted by locale.
     *
     * @return array<string, string>
     */
    public function translated(): array
    {
        if ($this->translated === null) {
            $this->translated = array_map(
                static fn(string $name): string => Translation::t($name),
                $this->all(),
            );
            asort($this->translated, SORT_LOCALE_STRING);
        }

        return $this->translated;
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
        throw new LogicException('Tld is read-only.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Tld is read-only.');
    }

    public function count(): int
    {
        return count($this->all());
    }

    /**
     * Checks whether a TLD is generic (not a country-code TLD).
     *
     * A TLD is considered generic if it is NOT present in the ccTLD data.
     */
    public function isGeneric(string $tld): bool
    {
        return !$this->offsetExists($tld);
    }
}
