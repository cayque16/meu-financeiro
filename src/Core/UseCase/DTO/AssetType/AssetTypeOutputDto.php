<?php

namespace Core\UseCase\DTO\AssetType;

use Core\Domain\ValueObject\Date;

class AssetTypeOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool $isActive,
        public ?Date $createdAt = null,
        public ?Date $updatedAt = null,
        public ?Date $deletedAt = null,
    ) { }
}
