<?php

namespace Core\UseCase\DTO\Asset\ActivateDisable;

class ActivateDisableAssetOutputDto
{
    public function __construct(
        public bool $success
    ) { }
}
