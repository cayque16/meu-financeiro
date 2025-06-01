<?php

namespace Core\UseCase\DTO\Brokerage\ActivateDisable;

class ActivateDisableBrokerageInputDto
{
    public function __construct(
        public string $id,
        public bool $activate = true,
    ) { }
}
