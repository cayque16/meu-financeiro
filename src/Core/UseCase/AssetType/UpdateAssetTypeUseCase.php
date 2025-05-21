<?php

namespace Core\UseCase\AssetType;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class UpdateAssetTypeUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository,
    ) { }

    public function execute(UpdateAssetTypeInputDto $input): UpdateAssetTypeOutputDto
    {
        $type = $this->repository->findById($input->id);

        if ($type) {
            $type->update($input->name, $input->description);
            $return = $this->repository->update($type);

            return new UpdateAssetTypeOutputDto(
                id: $return->id(),
                name: $return->name,
                description: $return->description,
                // isActive: $return->isActive(),
                createdAt: $return->createdAt,
                oldId: $return->oldId,
            );
        }
        throw new NotFoundException("No AssetType with that id was found: {$input->id}");
    }
}
