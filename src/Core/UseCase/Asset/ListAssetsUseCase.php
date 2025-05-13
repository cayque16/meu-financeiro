<?php

namespace Core\UseCase\Asset;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsOutputDto;

class ListAssetsUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository,
    ) { }

    public function execute(ListAssetsInputDto $input): ListAssetsOutputDto
    {
        $assets = $this->repository->findAll(
            filter: $input->filter,
            orderBy: $input->order,
        );

        return new ListAssetsOutputDto($assets);
    }
}
