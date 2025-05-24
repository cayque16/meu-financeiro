<?php

namespace Core\UseCase\DTO\Asset\ActivateDisable;

class ActivateDisableAssetInputDto
{
    public function __construct(
        public string $id,
        public bool $activate = true,
    ) { }
}
