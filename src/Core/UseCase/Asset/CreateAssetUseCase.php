<?php

namespace Core\UseCase\Asset;

use Core\Domain\Entity\Asset;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\Asset\Create\CreateAssetInputDto;
use Core\UseCase\DTO\Asset\Create\CreateAssetOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class CreateAssetUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repoAsset,
        protected BaseRepositoryInterface $repoAssetType,
    ) { }

    public function execute(CreateAssetInputDto $input): CreateAssetOutputDto
    {
        $type = $this->repoAssetType->findById($input->idType);
        
        if ($type) {
            $asset = new Asset(
                code: $input->code,
                description: $input->description,
                type: $type,
            );
            $return = $this->repoAsset->insert($asset);

            return new CreateAssetOutputDto(
                id: $return->id(),
                code: $return->code,
                description: $return->description,
                idType: $type->id(),
                // isActive: $return->isActive(),
                createdAt: $return->createdAt,
            );
        }
        throw new NotFoundException("No asset type with that id was found: {$input->idType}");
    }
}
