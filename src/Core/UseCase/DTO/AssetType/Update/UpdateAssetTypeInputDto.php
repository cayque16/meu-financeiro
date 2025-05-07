<?php

namespace Core\UseCase\DTO\AssetType\Update;

class UpdateAssetTypeInputDto 
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description = '',
    ) { }
}
