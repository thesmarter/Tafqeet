<?php

declare(strict_types=1);

namespace thesmarter\Tafqeet\Tests;

use PHPUnit\Framework\TestCase;
use thesmarter\Tafqeet\Core\Tafqeet;
use thesmarter\Tafqeet\Exception\TafqeetException;

final class TafqeetTest extends TestCase
{
    public function testZero(): void
    {
        $this->assertSame('فقط صفر ريال لاغير', Tafqeet::arablic(0));
    }

    public function testSingleDigit(): void
    {
        $this->assertSame('فقط واحد ريال لاغير', Tafqeet::arablic(1));
    }

    public function testThousands(): void
    {
        $this->assertSame('فقط ألف ريال لاغير', Tafqeet::arablic(1000));
    }

    public function testHundred(): void
    {
        $this->assertSame('فقط مائة ريال لاغير', Tafqeet::arablic(100));
    }

    public function testWithDecimal(): void
    {
        $this->assertSame(
            'فقط ثلاثة آلاف ومائة وخمسون ريالاً وتسعة هللات لاغير',
            Tafqeet::arablic(3150.9),
        );
    }

    public function testMaxRange(): void
    {
        $this->assertSame(
            'فقط تسعمائة وتسعة وتسعون ألفًا وتسعمائة وتسعة وتسعون ريالاً لاغير',
            Tafqeet::arablic(999999),
        );
    }

    public function testDollarCurrency(): void
    {
        $this->assertSame(
            'فقط مائة وثلاثة وعشرون ألفًا وأربعمائة وستة وخمسون دولاراً وثمانية وسبعون سنت لاغير',
            Tafqeet::arablic(123456.78, 'usd'),
        );
    }

    public function testSdgCurrency(): void
    {
        $this->assertSame('فقط خمسمائة قرش وخمسة وعشرون قرش لاغير', Tafqeet::arablic(500.25, 'sdg'));
    }

    public function testStringInput(): void
    {
        $this->assertSame('فقط ألف ريال لاغير', Tafqeet::arablic('1000'));
    }

    public function testInvalidInputThrowsException(): void
    {
        $this->expectException(TafqeetException::class);
        Tafqeet::arablic('invalid');
    }

    public function testObjectConstruction(): void
    {
        $tafqeet = new Tafqeet(1500.5);
        $this->assertSame('فقط ألف وخمسمائة ريال وخمسة هللات لاغير', $tafqeet->toWords('sar'));
    }
}
