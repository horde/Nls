<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * Maps retired/renamed ISO-3166 codes to their successors for historic
 * data processing.
 */

namespace Horde\Nls;

/**
 * LegacyCodes maps retired or renamed ISO-3166 codes to their primary
 * successor codes, enabling historic data to be resolved to current
 * country identifiers.
 */
class LegacyCodes
{
    /**
     * Retired alpha-2 codes mapped to their primary successor alpha-2 code.
     */
    private const ALPHA2_MAP = [
        'AN' => 'BQ', // Netherlands Antilles, dissolved 2010; BQ primary, CW and SX also successors
        'YU' => 'RS', // Yugoslavia => Serbia as primary
        'ZR' => 'CD', // Zaire => DR Congo
        'TP' => 'TL', // East Timor code change
        'FX' => 'FR', // Metropolitan France, never real
        'CS' => 'RS', // Serbia and Montenegro => Serbia as primary
        'SU' => 'RU', // Soviet Union => Russia as primary
        'DD' => 'DE', // East Germany => Germany
        'BU' => 'MM', // Burma => Myanmar
    ];

    /**
     * Retired alpha-3 codes mapped to their successor alpha-3 code.
     */
    private const ALPHA3_MAP = [
        'ANT' => 'BES',
        'YUG' => 'SRB',
        'ZAR' => 'COD',
        'TMP' => 'TLS',
        'FXX' => 'FRA',
        'SCG' => 'SRB',
        'SUN' => 'RUS',
        'DDR' => 'DEU',
        'BUR' => 'MMR',
    ];

    /**
     * Old English country names mapped to current alpha-2 codes.
     */
    private const NAME_MAP = [
        'Czech Republic' => 'CZ',
        'Swaziland' => 'SZ',
        'Macedonia, the Former Yugoslav Republic of' => 'MK',
        'Turkey' => 'TR',
        'Cape Verde' => 'CV',
        'Burma' => 'MM',
        'Zaire' => 'CD',
        'Yugoslavia' => 'RS',
        'Netherlands Antilles' => 'BQ',
        'East Timor' => 'TL',
    ];

    /**
     * Resolve a retired alpha-2 code to its primary successor.
     *
     * @param string $code Retired two-letter country code.
     *
     * @return string|null Primary successor alpha-2 code, or null if not found.
     */
    public function resolve(string $code): ?string
    {
        $code = strtoupper($code);

        return self::ALPHA2_MAP[$code] ?? null;
    }

    /**
     * Resolve a retired alpha-3 code to its successor.
     *
     * @param string $code Retired three-letter country code.
     *
     * @return string|null Successor alpha-3 code, or null if not found.
     */
    public function resolveAlpha3(string $code): ?string
    {
        $code = strtoupper($code);

        return self::ALPHA3_MAP[$code] ?? null;
    }

    /**
     * Resolve an old English country name to its current alpha-2 code.
     *
     * @param string $name Old English country name.
     *
     * @return string|null Current alpha-2 code, or null if not found.
     */
    public function resolveName(string $name): ?string
    {
        $normalized = strtolower($name);

        foreach (self::NAME_MAP as $oldName => $code) {
            if (strtolower($oldName) === $normalized) {
                return $code;
            }
        }

        return null;
    }

    /**
     * Return the full alpha-2 retirement map.
     *
     * @return array<string, string> Retired alpha-2 code => primary successor.
     */
    public function allCodeAliases(): array
    {
        return self::ALPHA2_MAP;
    }

    /**
     * Return the full alpha-3 retirement map.
     *
     * @return array<string, string> Retired alpha-3 code => successor alpha-3.
     */
    public function allAlpha3Aliases(): array
    {
        return self::ALPHA3_MAP;
    }

    /**
     * Return the full name alias map.
     *
     * @return array<string, string> Old English name => current alpha-2 code.
     */
    public function allNameAliases(): array
    {
        return self::NAME_MAP;
    }
}
