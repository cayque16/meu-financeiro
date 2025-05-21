<?php

namespace Core\UseCase\DTO\Asset\Create;

use Core\Domain\ValueObject\Date;

class CreateAssetOutputDto
{
    public function __construct(
        public string $id,
        public string $code,
        public string $description,
        public string $idType,
        // public bool $isActive,
        public Date $createdAt,
    ) { }
}
