<?php

namespace Core\UseCase\DTO\Asset;

class AssetOutputDto
{
    public function __construct(
        public string $id,
        public string $code,
        public string $description,
        public string $typeId,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
