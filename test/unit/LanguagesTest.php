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
 * Data validation tests for Languages.php.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Nls
 */
#[CoversNothing]
class LanguagesTest extends TestCase
{
    /**
     * Test Languages.php data file loads successfully.
     */
    public function testLanguagesDataLoads(): void
    {
        $languages = [];
        require __DIR__ . '/../../lib/Horde/Nls/Languages.php';

        $this->assertIsArray($languages);
        $this->assertNotEmpty($languages);
    }

    /**
     * Test language data structure is valid.
     */
    public function testLanguagesDataStructure(): void
    {
        $languages = [];
        require __DIR__ . '/../../lib/Horde/Nls/Languages.php';

        foreach ($languages as $code => $name) {
            $this->assertIsString($code, 'Language code must be string');
            $this->assertMatchesRegularExpression('/^[a-z]{2}$/', $code, "Language code must be 2 lowercase letters: {$code}");
            $this->assertIsString($name, 'Language name must be string');
            $this->assertNotEmpty($name, "Language name must not be empty for code: {$code}");
        }
    }

    /**
     * Test well-known languages are present.
     */
    public function testWellKnownLanguages(): void
    {
        $languages = [];
        require __DIR__ . '/../../lib/Horde/Nls/Languages.php';

        $expected = [
            'en' => true, // English
            'de' => true, // German
            'fr' => true, // French
            'es' => true, // Spanish
            'ja' => true, // Japanese
            'zh' => true, // Chinese
            'ar' => true, // Arabic
            'ru' => true, // Russian
        ];

        foreach (array_keys($expected) as $code) {
            $this->assertArrayHasKey($code, $languages, "Language {$code} should be present");
        }
    }
}
