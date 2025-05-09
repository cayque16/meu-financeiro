<?php

namespace Core\UseCase\DTO\Asset;

class CreateAssetInputDto
{
    public function __construct(
        public string $code,
        public string $idType,
        public string $description = '',
    ) { }
}
