<?php

namespace Core\UseCase\DTO\AssetType\Update;

use Core\Domain\ValueObject\Date;

class UpdateAssetTypeOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        // public bool $isActive,
        public Date $createdAt,
        public int $oldId,
    ) { }
}
