<?php

namespace Core\UseCase\DTO\Asset;

class CreateAssetOutputDto
{
    public function __construct(
        public string $id,
        public string $code,
        public string $description,
        public string $idType,
        public bool $isActive,
        public string $createdAt,
    ) { }
}
