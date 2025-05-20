<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\AssetType\ListAssetsTypesUseCase;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListAssetsTypesUseCaseUnitTest extends TestCase
{
    public function testListAll()
    {
        $mockRepository = Mockery::mock(stdClass::class, AssetTypeRepositoryInterface::class);
        $mockRepository->shouldReceive("findAll")->once()->andReturn([]);

        $useCase = new ListAssetsTypesUseCase($mockRepository);

        $mockInputDto = Mockery::mock(ListAssetsTypesInputDto::class, ['', 'DESC']);

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListAssetsTypesOutputDto::class, $response);
    }
}
