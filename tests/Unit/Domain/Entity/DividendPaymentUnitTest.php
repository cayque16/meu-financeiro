<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\Currency;
use Core\Domain\Entity\DividendPayment;
use Core\Domain\Enum\DividendType;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Date;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DividendPaymentUnitTest extends TestCase
{
    public function testConstruct()
    {
        $payment =  new DividendPayment(
            $this->mockAsset(),
            new Date(),
            DividendType::DIVIDENDS,
            150,
            $this->mockCurrency()
        );

        $this->assertNotNull($payment->id());
        $this->assertInstanceOf(Date::class, $payment->createdAt);
        $this->assertSame("", $payment->deletedAt);
        $this->assertSame("", $payment->updatedAt);
    }

    public function testExceptionsInConstructor()
    {
        $this->expectException(EntityValidationException::class);
        new DividendPayment(
            $this->mockAsset(),
            new Date(),
            DividendType::DIVIDENDS,
            0,
            $this->mockCurrency()
        );
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
