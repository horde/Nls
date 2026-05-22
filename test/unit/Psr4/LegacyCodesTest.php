<?php

declare(strict_types=1);

namespace Horde\Nls\Test\Psr4;

use Horde\Nls\LegacyCodes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(LegacyCodes::class)]
class LegacyCodesTest extends TestCase
{
    private LegacyCodes $legacy;

    protected function setUp(): void
    {
        $this->legacy = new LegacyCodes();
    }

    #[Test]
    public function resolveRetiredAlpha2(): void
    {
        $this->assertSame('BQ', $this->legacy->resolve('AN'));
        $this->assertSame('RS', $this->legacy->resolve('YU'));
        $this->assertSame('CD', $this->legacy->resolve('ZR'));
        $this->assertSame('TL', $this->legacy->resolve('TP'));
        $this->assertSame('FR', $this->legacy->resolve('FX'));
    }

    #[Test]
    public function resolveIsCaseInsensitive(): void
    {
        $this->assertSame('BQ', $this->legacy->resolve('an'));
        $this->assertSame('RS', $this->legacy->resolve('yu'));
    }

    #[Test]
    public function resolveReturnsNullForCurrentCodes(): void
    {
        $this->assertNull($this->legacy->resolve('DE'));
        $this->assertNull($this->legacy->resolve('US'));
    }

    #[Test]
    public function resolveAlpha3(): void
    {
        $this->assertSame('BES', $this->legacy->resolveAlpha3('ANT'));
        $this->assertSame('SRB', $this->legacy->resolveAlpha3('YUG'));
        $this->assertSame('COD', $this->legacy->resolveAlpha3('ZAR'));
    }

    #[Test]
    public function resolveName(): void
    {
        $this->assertSame('CZ', $this->legacy->resolveName('Czech Republic'));
        $this->assertSame('SZ', $this->legacy->resolveName('Swaziland'));
        $this->assertSame('MK', $this->legacy->resolveName('Macedonia, the Former Yugoslav Republic of'));
    }

    #[Test]
    public function resolveNameReturnsNullForCurrentNames(): void
    {
        $this->assertNull($this->legacy->resolveName('Germany'));
    }
}
