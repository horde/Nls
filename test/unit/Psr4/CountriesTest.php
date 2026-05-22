<?php

declare(strict_types=1);

namespace Horde\Nls\Test\Psr4;

use Horde\Nls\Countries;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Countries::class)]
class CountriesTest extends TestCase
{
    private Countries $countries;

    protected function setUp(): void
    {
        $this->countries = new Countries();
    }

    #[Test]
    public function allReturnsNonEmptyArray(): void
    {
        $all = $this->countries->all();
        $this->assertNotEmpty($all);
        $this->assertGreaterThan(200, count($all));
    }

    #[Test]
    public function getReturnsCountryName(): void
    {
        $this->assertSame('Germany', $this->countries->get('DE'));
        $this->assertSame('Germany', $this->countries->get('de'));
    }

    #[Test]
    public function getReturnsNullForUnknown(): void
    {
        $this->assertNull($this->countries->get('XX'));
    }

    #[Test]
    public function updatedCountryNames(): void
    {
        $this->assertSame('Czechia', $this->countries->get('CZ'));
        $this->assertSame('North Macedonia', $this->countries->get('MK'));
        $this->assertSame('Eswatini', $this->countries->get('SZ'));
        $this->assertSame('Cabo Verde', $this->countries->get('CV'));
    }

    #[Test]
    public function retiredCodesNotPresent(): void
    {
        $this->assertNull($this->countries->get('AN'));
        $this->assertNull($this->countries->get('YU'));
        $this->assertNull($this->countries->get('ZR'));
    }

    #[Test]
    public function iterationWorks(): void
    {
        $count = 0;
        foreach ($this->countries as $code => $name) {
            $this->assertIsString($code);
            $this->assertIsString($name);
            ++$count;
        }
        $this->assertSame(count($this->countries), $count);
    }

    #[Test]
    public function arrayAccessWorks(): void
    {
        $this->assertTrue(isset($this->countries['US']));
        $this->assertSame('United States', $this->countries['US']);
        $this->assertFalse(isset($this->countries['XX']));
    }

    #[Test]
    public function arrayAccessIsReadOnly(): void
    {
        $this->expectException(LogicException::class);
        $this->countries['XX'] = 'Test';
    }

    #[Test]
    public function countable(): void
    {
        $this->assertSame(249, count($this->countries));
    }
}
