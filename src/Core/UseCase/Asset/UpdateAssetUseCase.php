<?php

namespace Core\UseCase\Asset;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Asset\Update\UpdateAssetInputDto;
use Core\UseCase\DTO\Asset\Update\UpdateAssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class UpdateAssetUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repoAsset,
        protected BaseRepositoryInterface $repoAssetType,
    ) { }

    public function execute(UpdateAssetInputDto $input): UpdateAssetOutputDto
    {
        $asset = $this->repoAsset->findById($input->id)
            ?? throw new NotFoundException("No asset with that id was found: {$input->id}");
        $type = $this->repoAssetType->findById($input->idType)
            ?? throw new NotFoundException("No asset type with that id was found: {$input->idType}");;

        $asset->update(
            code: $input->code,
            type: $type,
            description: $input->description,
        );

        $return = $this->repoAsset->update($asset);
        
        return new UpdateAssetOutputDto(
            id: $return->id(),
            code: $return->code,
            description: $return->description,
            idType: $return->type->id(),
            isActive: $return->isActive(),
            createdAt: $return->createdAt(),
        );
    }
}
