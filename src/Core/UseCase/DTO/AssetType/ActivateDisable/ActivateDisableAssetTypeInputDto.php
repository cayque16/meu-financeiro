<?php

namespace Core\UseCase\DTO\AssetType\ActivateDisable;

class ActivateDisableAssetTypeInputDto
{
    public function __construct(
        public string $id,
        public bool $activate = true,
    ) { }
}
