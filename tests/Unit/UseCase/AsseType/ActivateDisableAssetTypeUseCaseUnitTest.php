<?php

namespace Tests\Unit\UseCase\AsseType;

use Core\Domain\Repository\AssetTypeRepositoryInterface;

use Core\UseCase\AssetType\ActivateDisableAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeOutputDto;
use Mockery;
use stdClass;
use Tests\Unit\UseCase\AbstractActivateDisableUseCaseTest;

class ActivateDisableAssetTypeUseCaseUnitTest extends AbstractActivateDisableUseCaseTest
{
    
    protected function getUseCase($mockRepo)
    {
        return new ActivateDisableAssetTypeUseCase($mockRepo);
    }

    protected function getOutputDto()
    {
        return ActivateDisableAssetTypeOutputDto::class;
    }

    protected function getRepositoryInterface()
    {
        return AssetTypeRepositoryInterface::class;
    }

    protected function getInputDto()
    {
        return ActivateDisableAssetTypeInputDto::class;
    }   
}
