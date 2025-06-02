<?php

namespace Tests\Unit\UseCase\Brokerage;

use Core\Domain\Entity\Brokerage;
use Core\Domain\Repository\BrokerageRepositoryInterface;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Brokerage\CreateBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateBrokerageUseCaseUnitTest extends TestCase
{
    public function testCreate()
    {
        $uuid = (string) Uuid::random();
        $cnpj = Cnpj::random();
        $date = new Date();
        $url = 'http://nitlefu.gg/robnungek';

        $mockEntity = Mockery::mock(Brokerage::class, ['test', $url, $cnpj, $uuid]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('isActive')->andReturn(true);
        $mockEntity->shouldReceive('createdAt')->once()->andReturn($date);
        $mockEntity->shouldReceive('updatedAt')->once()->andReturn(null);
        $mockEntity->shouldReceive('deletedAt')->once()->andReturn(null);

        $mockRepository = Mockery::mock(stdClass::class, BrokerageRepositoryInterface::class);
        $mockRepository->shouldReceive("insert")
            ->once()
            ->andReturn($mockEntity);

        $useCase = new CreateBrokerageUseCase($mockRepository);

        $mockInput = Mockery::mock(CreateBrokerageInputDto::class, ['test', $url, $cnpj]);
        $response = $useCase->execute($mockInput);

        $this->assertInstanceOf(CreateBrokerageOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals('test', $response->name);
        $this->assertEquals($url, $response->webPage);
        $this->assertEquals($cnpj, $response->cnpj);
        $this->assertTrue($response->isActive);
        $this->assertEquals($date, $response->createdAt);
        $this->assertNull($response->updatedAt);
        $this->assertNull($response->deletedAt);

        Mockery::close();
    }
}
