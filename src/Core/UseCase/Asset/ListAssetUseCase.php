<?php

namespace Core\UseCase\Asset;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Asset\AssetInputDto;
use Core\UseCase\DTO\Asset\AssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class ListAssetUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository,
    ) { }

    public function execute(AssetInputDto $input): AssetOutputDto
    {
        $asset = $this->repository->findById($input->id)
            ?? throw new NotFoundException("No asset with that id was found: {$input->id}");
        
        return new AssetOutputDto(
            id: $asset->id(),
            code: $asset->code,
            description: $asset->description,
            typeId: $asset->type->id(),
            isActive: $asset->isActive(),
            createdAt: $asset->createdAt(),
            updatedAt: $asset->updatedAt(),
            deletedAt: $asset->deletedAt(),
        );
    }
}
