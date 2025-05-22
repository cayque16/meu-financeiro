<?php

namespace Core\UseCase\DTO\AssetType\ActivateDisable;

class ActivateDisableAssetTypeOutputDto
{
    public function __construct(
        public bool $success
    ) { }
}
