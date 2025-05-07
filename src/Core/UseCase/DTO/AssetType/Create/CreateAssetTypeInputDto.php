<?php

namespace Core\UseCase\DTO\AssetType\Create;

class CreateAssetTypeInputDto
{
    public function __construct(
        public string $name,
        public string $description = '',
    ) { }
}
