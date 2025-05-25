<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\BaseEntity;
use Core\Domain\Entity\Currency;
use Core\Domain\Entity\DividendPayment;
use Core\Domain\Enum\DividendType;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Date;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DividendPaymentUnitTest extends EntityTestCaseUnitTest
{
    protected function entity(): BaseEntity
    {
        $payment =  new DividendPayment(
            $this->mockAsset(),
            new Date(),
            2024,
            DividendType::DIVIDENDS,
            150,
            $this->mockCurrency()
        );

        return $payment;
    }

    /**
     * @dataProvider providerConstructor
     */
    public function testExceptionsInConstructor($fiscalYear, $amount)
    {
        $this->expectException(EntityValidationException::class);
        new DividendPayment(
            $this->mockAsset(),
            new Date(),
            $fiscalYear,
            DividendType::DIVIDENDS,
            $amount,
            $this->mockCurrency()
        );
    }

    protected function providerConstructor()
    {
        return [
            'yearBelowTheMinimum' => [1500, 150],
            'yearAboveMaximum' => [2250, 150],
            'amountBelowTheMinimum' => [2024, 0],
        ];
    }

    public function testGetAmountFormatted()
    {
        $mockCurrency = Mockery::mock(
            Currency::class,
            ['Real', 'R$', 'BRL', 100, 2, $this->getUuid(), 'desc']
        );
        $mockCurrency->shouldReceive('printFormatted')->once()->andReturn('R$ 15,00');

        $payment = new DividendPayment(
            $this->mockAsset(),
            new Date(),
            2024,
            DividendType::DIVIDENDS,
            1500,
            $mockCurrency,
        );

        $this->assertEquals("R$ 15,00", $payment->getAmountFormatted());
    }

    private function mockAsset()
    {
        $mockAsset = Mockery::mock(Asset::class, ['BTC', $this->mockType()]);

        return $mockAsset;
    }

    private function mockType()
    {
        $mockType = Mockery::mock(AssetType::class, ['stock']);

        return $mockType;
    }

    private function mockCurrency()
    {
        $mockCurrency = Mockery::mock(
            Currency::class,
            ['Real', 'R$', 'BRL', 100, 2, $this->getUuid(), 'desc']
        );

        return $mockCurrency;
    }

    private function getUuid()
    {
        $uuid = (string) Uuid::uuid4();

        return $uuid;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
