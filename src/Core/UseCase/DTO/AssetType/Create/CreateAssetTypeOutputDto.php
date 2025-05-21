<?php

namespace Core\UseCase\DTO\AssetType\Create;

use Core\Domain\ValueObject\Date;

class CreateAssetTypeOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        // public bool $isActive,
        public Date $createdAt,
    ) { }
}
