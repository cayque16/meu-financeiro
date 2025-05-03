<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Currency;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
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

    public function testDisable()
    {
        $currency = new Currency(
            name: 'test',
            symbol: 'R$',
            isoCode: 'BRL',
            split: 100,
            description: 'new test'
        );

        $currency->disable();
        $this->assertNotTrue($currency->isActive);
    }

    public function testActivate()
    {
        $currency = new Currency(
            name: 'test',
            symbol: 'R$',
            isoCode: 'BRL',
            split: 100,
            description: 'new test',
            isActive: false
        );

        $currency->activate();
        $this->assertTrue($currency->isActive);
    }
}
