<?php

namespace Core\UseCase\DTO\AssetType\Update;

class UpdateAssetTypeOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
