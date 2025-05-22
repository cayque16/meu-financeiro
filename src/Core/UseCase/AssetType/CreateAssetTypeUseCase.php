<?php

namespace Core\UseCase\AssetType;

use Core\Domain\Entity\AssetType;
use Core\Domain\Repository\AssetTypeRepositoryInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeOutputDto;

class CreateAssetTypeUseCase
{
    public function __construct(
        protected AssetTypeRepositoryInterface $repository,
    ) { }

    public function execute(CreateAssetTypeInputDto $input): CreateAssetTypeOutputDto
    {
        $type = new AssetType(
            name: $input->name,
            description: $input->description
        );
        $return = $this->repository->insert($type);

        return new CreateAssetTypeOutputDto(
            id: $return->id(),
            name: $return->name,
            description: $return->description,
            isActive: $return->isActive(),
            createdAt: $return->createdAt(),
            updatedAt: $return->updatedAt(),
            deletedAt: $return->deletedAt(),
        );
    }
}
