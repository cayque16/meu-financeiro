<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\Asset\ListAssetsUseCase;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListAssetsUseCaseUnitTest extends TestCase
{
    public function testListAll()
    {
        $mockRepository = Mockery::mock(stdClass::class, AssetRepositoryInterface::class);
        $mockRepository->shouldReceive("findAll")->once()->andReturn([]);

        $useCase = new ListAssetsUseCase($mockRepository);

        $mockInputDto = Mockery::mock(ListAssetsInputDto::class, ['', 'DESC']);

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListAssetsOutputDto::class, $response);
    }
}
