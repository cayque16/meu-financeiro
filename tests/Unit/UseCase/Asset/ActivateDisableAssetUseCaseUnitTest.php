<?php

namespace Tests\Unit\UseCase\Asset;

use Core\Domain\Repository\AssetRepositoryInterface;
use Core\UseCase\Asset\ActivateDisableAssetUseCase;
use Core\UseCase\DTO\Asset\ActivateDisable\ActivateDisableAssetInputDto;
use Core\UseCase\DTO\Asset\ActivateDisable\ActivateDisableAssetOutputDto;
use Mockery;
use stdClass;
use Tests\Unit\UseCase\AbstractActivateDisableUseCaseTest;

class ActivateDisableAssetUseCaseUnitTest extends AbstractActivateDisableUseCaseTest
{
    protected function getUseCase($mockRepo)
    {
        return new ActivateDisableAssetUseCase($mockRepo);
    }

    protected function getOutputDto()
    {
        return ActivateDisableAssetOutputDto::class;
    }

    protected function getRepositoryInterface()
    {
        return AssetRepositoryInterface::class;
    }

    protected function getInputDto()
    {
        return ActivateDisableAssetInputDto::class;
    }
}
