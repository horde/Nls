<?php

declare(strict_types=1);

namespace Horde\Nls\Test\Psr4;

use Horde\Nls\Tld;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tld::class)]
class TldTest extends TestCase
{
    private Tld $tld;

    protected function setUp(): void
    {
        $this->tld = new Tld();
    }

    #[Test]
    public function getReturnsMappedCountry(): void
    {
        $this->assertSame('Germany', $this->tld->get('de'));
        $this->assertSame('France', $this->tld->get('fr'));
    }

    #[Test]
    public function getIsCaseInsensitive(): void
    {
        $this->assertSame('Germany', $this->tld->get('DE'));
    }

    #[Test]
    public function getReturnsNullForUnknown(): void
    {
        $this->assertNull($this->tld->get('zzz'));
    }

    #[Test]
    public function isGenericReturnsTrueForNonCcTlds(): void
    {
        $this->assertTrue($this->tld->isGeneric('com'));
        $this->assertTrue($this->tld->isGeneric('xyz'));
        $this->assertTrue($this->tld->isGeneric('app'));
    }

    #[Test]
    public function isGenericReturnsFalseForCcTlds(): void
    {
        $this->assertFalse($this->tld->isGeneric('de'));
        $this->assertFalse($this->tld->isGeneric('fr'));
        $this->assertFalse($this->tld->isGeneric('uk'));
    }

    #[Test]
    public function retiredTldsRemoved(): void
    {
        $this->assertNull($this->tld->get('an'));
        $this->assertNull($this->tld->get('yu'));
    }
}
