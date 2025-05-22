<?php

namespace Core\UseCase\AssetType;

use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeOutputDto;

class ActivateDisableAssetTypeUseCase
{
    public function __construct(
        private AssetTypeRepositoryInterface $repository,
    ) { }

    public function execute(ActivateDisableAssetTypeInputDto $input): ActivateDisableAssetTypeOutputDto
    {
        $result = $input->activate ?
            $this->repository->activate($input->id)
            : $this->repository->disable($input->id);

        return new ActivateDisableAssetTypeOutputDto(success: $result);
    }
}
