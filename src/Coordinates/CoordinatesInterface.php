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

namespace Horde\Nls\Coordinates;

/**
 * Contract for geographic coordinate data providers.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
interface CoordinatesInterface
{
    /**
     * Returns city coordinates for a given country.
     *
     * @param string $country Country name (English)
     *
     * @return array<string, string> Keys: "lat:long", Values: city name
     */
    public function forCountry(string $country): array;

    /**
     * Returns all available country names.
     *
     * @return list<string>
     */
    public function countries(): array;
}
