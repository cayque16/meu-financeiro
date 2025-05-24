<?php

namespace Core\UseCase\Asset;

use Core\Domain\Repository\AssetRepositoryInterface;
use Core\UseCase\DTO\Asset\ActivateDisable\ActivateDisableAssetInputDto;
use Core\UseCase\DTO\Asset\ActivateDisable\ActivateDisableAssetOutputDto;

class ActivateDisableAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
    ) { }

    public function execute(ActivateDisableAssetInputDto $input): ActivateDisableAssetOutputDto
    {
        $result = $input->activate ?
            $this->repository->activate($input->id)
            : $this->repository->disable($input->id);

        return new ActivateDisableAssetOutputDto(success: $result);
    }
}
