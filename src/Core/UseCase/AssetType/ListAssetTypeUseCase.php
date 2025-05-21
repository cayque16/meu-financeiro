<?php

namespace Core\UseCase\AssetType;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\AssetType\AssetTypeInputDto;
use Core\UseCase\DTO\AssetType\AssetTypeOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class ListAssetTypeUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository,
    ) { }

    public function execute(AssetTypeInputDto $input): AssetTypeOutputDto
    {
        $type = $this->repository->findById($input->id);

        if ($type) {
            return new AssetTypeOutputDto(
                id: $type->id,
                name: $type->name,
                description: $type->description,
                // isActive: $type->isActive(),
                createdAt: $type->createdAt,
            );
        }
        throw new NotFoundException("No asset with that id was found: {$input->id}");
    }
}
