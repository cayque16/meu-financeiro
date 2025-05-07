<?php

namespace Core\UseCase\DTO\AssetType\Create;

class CreateAssetTypeOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
