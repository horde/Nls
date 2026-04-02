<?php

declare(strict_types=1);

/**
 * Copyright 2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 */

namespace Horde\Nls\Test\Unit;

use Horde_Nls;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Horde_Nls class.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Nls
 */
#[CoversClass(Horde_Nls::class)]
class NlsTest extends TestCase
{
    /**
     * Test checkCharset() with valid charsets.
     */
    public function testCheckCharsetValid(): void
    {
        $this->assertTrue(Horde_Nls::checkCharset('UTF-8'));
        $this->assertTrue(Horde_Nls::checkCharset('ISO-8859-1'));
        $this->assertTrue(Horde_Nls::checkCharset('Windows-1252'));
    }

    /**
     * Test checkCharset() with invalid charsets.
     */
    #[DataProvider('invalidCharsetProvider')]
    public function testCheckCharsetInvalid(?string $charset): void
    {
        $this->assertFalse(Horde_Nls::checkCharset($charset));
    }

    /**
     * Data provider for invalid charsets.
     */
    public static function invalidCharsetProvider(): array
    {
        return [
            'null' => [null],
            'empty string' => [''],
        ];
    }

    /**
     * Test checkCharset() is case-insensitive.
     */
    public function testCheckCharsetCaseInsensitive(): void
    {
        $this->assertTrue(Horde_Nls::checkCharset('utf-8'));
        $this->assertTrue(Horde_Nls::checkCharset('UTF-8'));
        $this->assertTrue(Horde_Nls::checkCharset('Utf-8'));
    }

    /**
     * Test getTimezones() returns timezone list.
     */
    public function testGetTimezones(): void
    {
        $timezones = Horde_Nls::getTimezones();

        $this->assertIsArray($timezones);
        $this->assertNotEmpty($timezones);

        // Check format: timezone ID is both key and value
        foreach ($timezones as $key => $value) {
            $this->assertSame($key, $value);
        }

        // Spot check common timezones
        $this->assertArrayHasKey('America/New_York', $timezones);
        $this->assertArrayHasKey('Europe/London', $timezones);
        $this->assertArrayHasKey('Asia/Tokyo', $timezones);
        $this->assertArrayHasKey('UTC', $timezones);
    }

    /**
     * Test getTimezonesWithAbbreviations() returns timezones with abbreviations.
     */
    public function testGetTimezonesWithAbbreviations(): void
    {
        $timezones = Horde_Nls::getTimezonesWithAbbreviations();

        $this->assertIsArray($timezones);
        $this->assertNotEmpty($timezones);

        // Check format: labels (including abbreviations) as keys, IDs as values
        // Should include standard timezone IDs
        $this->assertContains('America/New_York', $timezones);
        $this->assertContains('Europe/London', $timezones);

        // Should include abbreviations (uppercase)
        // Note: Exact abbreviations depend on PHP version/platform
        // Just verify we have some short keys that look like abbreviations
        $abbreviationCount = 0;
        foreach (array_keys($timezones) as $key) {
            if (strlen($key) <= 4 && ctype_upper($key) && $key !== 'UTC') {
                $abbreviationCount++;
            }
        }
        $this->assertGreaterThan(0, $abbreviationCount, 'Should contain timezone abbreviations');
    }

    /**
     * Test getLocaleInfo() returns locale data.
     */
    public function testGetLocaleInfo(): void
    {
        $info = Horde_Nls::getLocaleInfo();

        $this->assertIsArray($info);
        $this->assertNotEmpty($info);

        // Check for expected keys from localeconv()
        $this->assertArrayHasKey('decimal_point', $info);
        $this->assertArrayHasKey('thousands_sep', $info);
    }

    /**
     * Test getLocaleInfo() caching works.
     */
    public function testGetLocaleInfoCaching(): void
    {
        $info1 = Horde_Nls::getLocaleInfo();
        $info2 = Horde_Nls::getLocaleInfo();

        // Should return same array reference (cached)
        $this->assertSame($info1, $info2);
    }

    /**
     * Test getLangInfo() returns language info when available.
     */
    public function testGetLangInfo(): void
    {
        if (!function_exists('nl_langinfo')) {
            $this->markTestSkipped('nl_langinfo() not available on this system');
        }

        $info = Horde_Nls::getLangInfo(CODESET);
        $this->assertIsString($info);
        $this->assertNotEmpty($info);
    }

    /**
     * Test getLangInfo() returns false when function not available.
     */
    public function testGetLangInfoNotAvailable(): void
    {
        if (function_exists('nl_langinfo')) {
            $this->markTestSkipped('nl_langinfo() is available, cannot test unavailable case');
        }

        $info = Horde_Nls::getLangInfo(CODESET);
        $this->assertFalse($info);
    }

    /**
     * Test getLangInfo() caching works.
     */
    public function testGetLangInfoCaching(): void
    {
        if (!function_exists('nl_langinfo')) {
            $this->markTestSkipped('nl_langinfo() not available on this system');
        }

        $info1 = Horde_Nls::getLangInfo(CODESET);
        $info2 = Horde_Nls::getLangInfo(CODESET);

        // Should return same value (cached)
        $this->assertSame($info1, $info2);
    }

    /**
     * Test getCountryISO() returns all countries.
     */
    public function testGetCountryISOAll(): void
    {
        $countries = Horde_Nls::getCountryISO();

        $this->assertIsArray($countries);
        $this->assertNotEmpty($countries);

        // Spot check well-known countries
        $this->assertArrayHasKey('US', $countries);
        $this->assertArrayHasKey('GB', $countries);
        $this->assertArrayHasKey('DE', $countries);
        $this->assertArrayHasKey('FR', $countries);
        $this->assertArrayHasKey('JP', $countries);
        $this->assertArrayHasKey('CN', $countries);

        $this->assertIsString($countries['US']);
        $this->assertNotEmpty($countries['US']);
    }

    /**
     * Test getCountryISO() returns specific country.
     */
    #[DataProvider('countryCodeProvider')]
    public function testGetCountryISOSpecific(string $code, string $expectedName): void
    {
        $name = Horde_Nls::getCountryISO($code);
        $this->assertSame($expectedName, $name);
    }

    /**
     * Data provider for country codes.
     */
    public static function countryCodeProvider(): array
    {
        return [
            'US uppercase' => ['US', 'United States'],
            'US lowercase' => ['us', 'United States'],
            'US mixed case' => ['Us', 'United States'],
            'GB' => ['GB', 'United Kingdom'],
            'DE' => ['DE', 'Germany'],
        ];
    }

    /**
     * Test getCountryISO() returns null for invalid code.
     */
    public function testGetCountryISOInvalid(): void
    {
        $this->assertNull(Horde_Nls::getCountryISO('XX'));
        $this->assertNull(Horde_Nls::getCountryISO('INVALID'));
    }

    /**
     * Test getLanguageISO() returns all languages.
     */
    public function testGetLanguageISOAll(): void
    {
        $languages = Horde_Nls::getLanguageISO();

        $this->assertIsArray($languages);
        $this->assertNotEmpty($languages);

        // Spot check well-known languages
        $this->assertArrayHasKey('en', $languages);
        $this->assertArrayHasKey('de', $languages);
        $this->assertArrayHasKey('fr', $languages);
        $this->assertArrayHasKey('es', $languages);
        $this->assertArrayHasKey('ja', $languages);
        $this->assertArrayHasKey('zh', $languages);

        $this->assertIsString($languages['en']);
        $this->assertNotEmpty($languages['en']);
    }

    /**
     * Test getLanguageISO() returns specific language.
     */
    #[DataProvider('languageCodeProvider')]
    public function testGetLanguageISOSpecific(string $code, string $expectedName): void
    {
        $name = Horde_Nls::getLanguageISO($code);
        $this->assertSame($expectedName, $name);
    }

    /**
     * Data provider for language codes.
     */
    public static function languageCodeProvider(): array
    {
        return [
            'en lowercase' => ['en', 'English'],
            'en uppercase' => ['EN', 'English'],
            'en mixed case' => ['En', 'English'],
            'en with whitespace' => [' en ', 'English'],
            'en-US (takes first 2 chars)' => ['en-US', 'English'],
            'de' => ['de', 'German'],
            'fr' => ['fr', 'French'],
        ];
    }

    /**
     * Test getLanguageISO() returns null for invalid code.
     */
    public function testGetLanguageISOInvalid(): void
    {
        $this->assertNull(Horde_Nls::getLanguageISO('xx'));
        $this->assertNull(Horde_Nls::getLanguageISO('invalid'));
    }

    /**
     * Test tldLookup() returns country for valid TLD.
     */
    #[DataProvider('tldProvider')]
    public function testTldLookup(string $tld, string $expectedCountry): void
    {
        $country = Horde_Nls::tldLookup($tld);
        $this->assertSame($expectedCountry, $country);
    }

    /**
     * Data provider for TLD lookups.
     */
    public static function tldProvider(): array
    {
        return [
            'de lowercase' => ['de', 'Germany'],
            'de uppercase' => ['DE', 'Germany'],
            'uk' => ['uk', 'United Kingdom'],
            'fr' => ['fr', 'France'],
            'jp' => ['jp', 'Japan'],
        ];
    }

    /**
     * Test tldLookup() returns null for invalid TLD.
     */
    public function testTldLookupInvalid(): void
    {
        $this->assertNull(Horde_Nls::tldLookup('invalid'));
        $this->assertNull(Horde_Nls::tldLookup('xyz'));
    }

    /**
     * Test tldLookup() caching works.
     */
    public function testTldLookupCaching(): void
    {
        $country1 = Horde_Nls::tldLookup('de');
        $country2 = Horde_Nls::tldLookup('de');

        // Should return same value (cached)
        $this->assertSame($country1, $country2);
    }

    /**
     * Test getCountryByHost() with TLD hostname.
     */
    public function testGetCountryByHostWithTld(): void
    {
        // Test with hostname that has known TLD
        $result = Horde_Nls::getCountryByHost('www.example.de');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertSame('de', $result['code']);
        $this->assertSame('Germany', $result['name']);
    }

    /**
     * Test getCountryByHost() with generic TLD returns false.
     */
    public function testGetCountryByHostWithGenericTld(): void
    {
        // .com is a generic TLD, should fall through to GeoIP (which returns false without datafile)
        $result = Horde_Nls::getCountryByHost('www.example.com');

        // Without GeoIP database, should return false
        $this->assertFalse($result);
    }

    /**
     * Test getCountryByHost() with invalid host returns false.
     */
    public function testGetCountryByHostInvalid(): void
    {
        $result = Horde_Nls::getCountryByHost('invalid');
        $this->assertFalse($result);
    }
}
