<?php

declare(strict_types=1);

/**
 * Copyright 2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 */

namespace Horde\Nls\Test\Unit;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

/**
 * Data validation tests for Countries.php.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Nls
 */
#[CoversNothing]
class CountriesTest extends TestCase
{
    /**
     * Test Countries.php data file loads successfully.
     */
    public function testCountriesDataLoads(): void
    {
        $countries = [];
        require __DIR__ . '/../../lib/Horde/Nls/Countries.php';

        $this->assertIsArray($countries);
        $this->assertNotEmpty($countries);
    }

    /**
     * Test country data structure is valid.
     */
    public function testCountriesDataStructure(): void
    {
        $countries = [];
        require __DIR__ . '/../../lib/Horde/Nls/Countries.php';

        foreach ($countries as $code => $name) {
            $this->assertIsString($code, 'Country code must be string');
            $this->assertMatchesRegularExpression('/^[A-Z]{2}$/', $code, "Country code must be 2 uppercase letters: {$code}");
            $this->assertIsString($name, 'Country name must be string');
            $this->assertNotEmpty($name, "Country name must not be empty for code: {$code}");
        }
    }

    /**
     * Test well-known countries are present.
     */
    public function testWellKnownCountries(): void
    {
        $countries = [];
        require __DIR__ . '/../../lib/Horde/Nls/Countries.php';

        $expected = [
            'US' => true, // United States
            'GB' => true, // United Kingdom
            'DE' => true, // Germany
            'FR' => true, // France
            'JP' => true, // Japan
            'CN' => true, // China
            'AU' => true, // Australia
            'CA' => true, // Canada
        ];

        foreach (array_keys($expected) as $code) {
            $this->assertArrayHasKey($code, $countries, "Country {$code} should be present");
        }
    }
}
