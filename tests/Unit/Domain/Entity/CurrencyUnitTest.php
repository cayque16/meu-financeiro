<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\BaseEntity;
use Core\Domain\Entity\Currency;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Date;
use PHPUnit\Framework\TestCase;

class CurrencyUnitTest extends EntityTestCaseUnitTest
{
    protected function entity(): BaseEntity
    {
        return new Currency("test", "R$", "BRL", 100, description: "desc");
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testExceptionsInConstructor(
        string $name,
        string $symbol,
        string $isoCode,
        int $split,
        string $description
    ) {
        $this->expectException(EntityValidationException::class);
        new Currency(
            name: $name,
            symbol: $symbol,
            isoCode: $isoCode,
            split: $split,
            description: $description
        );
    }

    protected function providerConstruct(): array
    {
        return [
            'Test with name incorrect' => [
                'name' => 't',
                'symbol' => 'R$',
                'isoCode' => 'BRL',
                'split' => 100,
                'description' => 'Test'
            ],
            'Test with symbol incorrect' => [
                'name' => 'test',
                'symbol' => '',
                'isoCode' => 'BRL',
                'split' => 100,
                'description' => 'Test'
            ],
            'Test with isoCode incorrect' => [
                'name' => 'test',
                'symbol' => 'R$',
                'isoCode' => 'L',
                'split' => 100,
                'description' => 'Test'
            ],
            'Test with description incorrect' => [
                'name' => 'test',
                'symbol' => 'R$',
                'isoCode' => 'BRL',
                'split' => 100,
                'description' => 't'
            ],
            'Test with split incorrect' => [
                'name'=> 'test',
                'symbol' => 'R$',
                'isoCode' => 'BRL',
                'split' => -1,
                'description' => 'test'
            ]            
        ];
    }

    public function testIsoCodeIsAlwaysUpperCase()
    {
        $isoCode = 'bRl';
        $currency = new Currency(
            name: 'test',
            symbol: 'R$',
            isoCode: $isoCode,
            split: 100,
            description: 'new test'
        );

        $this->assertEquals(strtoupper($isoCode), $currency->isoCode);
    }

    /*public function testDisable()
    {
        $currency = new Currency(
            name: 'test',
            symbol: 'R$',
            isoCode: 'BRL',
            split: 100,
            description: 'new test'
        );

        $this->assertNull($currency->getExcludedAt());
        $currency->disable();
        $this->assertNotNull($currency->getExcludedAt());
        $this->assertNotTrue($currency->isActive());
    }

    public function testActivate()
    {
        $currency = new Currency(
            name: 'test',
            symbol: 'R$',
            isoCode: 'BRL',
            split: 100,
            description: 'new test',
            excludedAt: new DateTime()
        );

        $this->assertNotNull($currency->getExcludedAt());
        $currency->activate();
        $this->assertNull($currency->getExcludedAt());
        $this->assertTrue($currency->isActive());
    }*/

    /**
     * @dataProvider providerPrint
     */
    public function testPrintFormatted(
        $symbol,
        $expected,
        $split,
        $decimals,
        $value
    ) {
        $currency = new Currency(
            name: 'test',
            symbol: $symbol,
            isoCode: 'BRL',
            split: $split,
            decimals: $decimals,
            description: 'new test',
        );

        $this->assertEquals($expected, $currency->printFormatted($value));
    }

    protected function providerPrint(): array
    {
        return [
            ['R$', 'R$ 1.500,00', 100, 2, 150000],
            ['R$', 'R$ 0,01', 100, 2, 1],
            ['R$', 'R$ 1,01', 100, 2, 101],
            ['R$', 'R$ 25.000,01', 100, 2, 2500001],
            ['₿', '₿ 0,01924866', 10**8, 8, 1924866],
        ];
    }
}
