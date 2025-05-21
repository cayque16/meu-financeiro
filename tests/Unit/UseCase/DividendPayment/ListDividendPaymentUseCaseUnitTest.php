<?php

namespace Tests\Unit\UseCase\DividendPayment;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\Currency;
use Core\Domain\Entity\DividendPayment;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\DividendPayment\ListDividendPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\DividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\DividendPaymentOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListDividendPaymentUseCaseUnitTest extends TestCase
{
    public function testListSingle()
    {
        $uuid = (string) Uuid::uuid4();
        $idAsset = (string) Uuid::uuid4();
        $idCurrency = (string) Uuid::uuid4();

        $mockEntity = $this->mockEntity($uuid, $idAsset, $idCurrency);
        $mockRepository = $this->mockRepository($uuid, $mockEntity);
        $mockInputDto = $this->mockInputDto($uuid);

        $useCase = new ListDividendPaymentUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(DividendPaymentOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals($idAsset, $response->idAsset);
        $this->assertEquals(DividendType::JCP, $response->type);
        $this->assertEquals(150, $response->amount);
        $this->assertEquals($idCurrency, $response->idCurrency);
    }

    public function testListNotFound()
    {
        $uuid = (string) Uuid::uuid4();

        $mockRepository = $this->mockRepository($uuid, null);
        $mockInputDto = $this->mockInputDto($uuid);
        $useCase = new ListDividendPaymentUseCase($mockRepository);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($mockInputDto);
    }

    private function mockRepository($uuid, $mockEntity)
    {
        $mockRepository = Mockery::mock(stdClass::class, BaseRepositoryInterface::class);
        $mockRepository->shouldReceive("findById")
            ->once()   
            ->with($uuid)
            ->andReturn($mockEntity);

        return $mockRepository;
    }

    private function getUuid()
    {
        $uuid = (string) Uuid::uuid4();

        return $uuid;
    }

    private function mockEntity($id, $idAsset, $idCurrency)
    {
        $date = new Date();
        $mockEntity = Mockery::mock(DividendPayment::class, [
            $this->mockAsset($idAsset),
            $date,
            DividendType::JCP,
            150,
            $this->mockCurrency($idCurrency),
            $id
        ]);
        $mockEntity->shouldReceive('id')->once()->andReturn($id);
        // $mockEntity->shouldReceive('date')->once()->andReturn($date);
        // $mockEntity->shouldReceive('isActive')->once()->andReturn(true);
        // $mockEntity->shouldReceive('createdAt')->once()->andReturn(date('Y-m-d H:i:s'));

        return $mockEntity;
    }

    private function mockAsset($uuid)
    {
        $mockEntity = Mockery::mock(Asset::class, [
            'BTC',
            $this->mockType($this->getUuid()),
            $uuid,
            'desc'
        ]);
        $mockEntity->shouldReceive('id')->once()->andReturn($uuid);

        return $mockEntity;
    }

    private function mockType($uuid)
    {
        $mockType = Mockery::mock(AssetType::class);
        $mockType->shouldReceive('id')->andReturn($uuid);

        return $mockType;
    }

    private function mockCurrency($uuid)
    {
        $mockCurrency = Mockery::mock(
            Currency::class,
            ['Real', 'R$', 'BRL', 100, 2, $this->getUuid(), 'desc']
        );
        $mockCurrency->shouldReceive('id')->once()->andReturn($uuid);

        return $mockCurrency;
    }

    private function mockInputDto($uuid)
    {
        return Mockery::mock(DividendPaymentInputDto::class, [$uuid]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
