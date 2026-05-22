<?php

declare(strict_types=1);

namespace Horde\Nls\Test\Psr4;

use Horde\Nls\Nls;
use Horde\Nls\Countries;
use Horde\Nls\Dns\NullResolver;
use Horde\Nls\Geoip\GeoipInterface;
use Horde\Nls\Geoip\NullDriver;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Nls::class)]
class NlsTest extends TestCase
{
    private Nls $nls;

    protected function setUp(): void
    {
        $this->nls = new Nls();
    }

    #[Test]
    public function checkCharsetValidUtf8(): void
    {
        $this->assertTrue($this->nls->checkCharset('UTF-8'));
        $this->assertTrue($this->nls->checkCharset('utf-8'));
    }

    #[Test]
    public function checkCharsetInvalid(): void
    {
        $this->assertFalse($this->nls->checkCharset(''));
        $this->assertFalse($this->nls->checkCharset('NOT-A-CHARSET'));
    }

    #[Test]
    public function checkCharsetAliases(): void
    {
        $this->assertTrue($this->nls->checkCharset('latin1'));
    }

    #[Test]
    public function getTimezonesReturnsArray(): void
    {
        $tz = $this->nls->getTimezones();
        $this->assertNotEmpty($tz);
        $this->assertArrayHasKey('UTC', $tz);
        $this->assertSame('UTC', $tz['UTC']);
    }

    #[Test]
    public function getTimezonesWithAbbreviationsContainsMore(): void
    {
        $tz = $this->nls->getTimezonesWithAbbreviations();
        $this->assertNotEmpty($tz);
        $this->assertArrayHasKey('CET', $tz);
    }

    #[Test]
    public function countriesReturnsInstance(): void
    {
        $this->assertInstanceOf(Countries::class, $this->nls->countries());
    }

    #[Test]
    public function getCountryByHostWithCcTld(): void
    {
        $result = $this->nls->getCountryByHost('example.de');
        $this->assertNotNull($result);
        $this->assertSame('de', $result['code']);
    }

    #[Test]
    public function getCountryByHostGenericTldReturnsNull(): void
    {
        // With NullDriver (no GeoIP), generic TLDs return null
        $result = $this->nls->getCountryByHost('example.com');
        $this->assertNull($result);
    }
}
