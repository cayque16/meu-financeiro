<?php

namespace Core\UseCase\Asset;

use Core\Domain\Repository\AssetRepositoryInterface;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsOutputDto;

class ListAssetsUseCase
{
    public function __construct(
        protected AssetRepositoryInterface $repository,
    ) { }

    public function execute(ListAssetsInputDto $input): ListAssetsOutputDto
    {
        $assets = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order,
            includeInactive: $input->includeInactive,
        );

        return new ListAssetsOutputDto($assets);
    }
}
