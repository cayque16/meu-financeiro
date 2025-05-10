<?php

namespace Core\UseCase\DTO\Asset\Update;

class UpdateAssetInputDto
{
    public function __construct(
        public string $id,
        public string $code,
        public string $idType,
        public string $description = '',
    ) { }
}
