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
 * Data validation tests for Tld.php.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Nls
 */
#[CoversNothing]
class TldTest extends TestCase
{
    /**
     * Test Tld.php data file loads successfully.
     */
    public function testTldDataLoads(): void
    {
        $tld = [];
        require __DIR__ . '/../../lib/Horde/Nls/Tld.php';

        $this->assertIsArray($tld);
        $this->assertNotEmpty($tld);
    }

    /**
     * Test TLD data structure is valid.
     */
    public function testTldDataStructure(): void
    {
        $tld = [];
        require __DIR__ . '/../../lib/Horde/Nls/Tld.php';

        foreach ($tld as $code => $country) {
            $this->assertIsString($code, 'TLD code must be string');
            $this->assertIsString($country, 'Country name must be string');
            $this->assertNotEmpty($country, "Country name must not be empty for TLD: {$code}");
        }
    }

    /**
     * Test well-known TLDs are present.
     */
    public function testWellKnownTlds(): void
    {
        $tld = [];
        require __DIR__ . '/../../lib/Horde/Nls/Tld.php';

        $expected = [
            'de', // Germany
            'uk', // United Kingdom
            'fr', // France
            'jp', // Japan
            'au', // Australia
            'ca', // Canada
        ];

        foreach ($expected as $code) {
            $this->assertArrayHasKey($code, $tld, "TLD {$code} should be present");
        }
    }

    /**
     * Test generic TLDs are not in the list.
     */
    public function testGenericTldsNotPresent(): void
    {
        $tld = [];
        require __DIR__ . '/../../lib/Horde/Nls/Tld.php';

        $generic = ['com', 'net', 'org', 'edu', 'gov', 'mil'];

        foreach ($generic as $code) {
            $this->assertArrayNotHasKey($code, $tld, "Generic TLD {$code} should not be present");
        }
    }
}
