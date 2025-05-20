<?php

namespace Core\UseCase\AssetType;

use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesOutputDto;

class ListAssetsTypesUseCase 
{
    public function __construct(
        protected AssetTypeRepositoryInterface $repository,
    ) { }

    public function execute(ListAssetsTypesInputDto $input): ListAssetsTypesOutputDto
    {
        $assetsTypes = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order,
        );

        return new ListAssetsTypesOutputDto($assetsTypes);
    }
}
