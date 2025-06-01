<?php

namespace Core\UseCase\DTO\Brokerage\ActivateDisable;

class ActivateDisableBrokerageOutputDto
{
    public function __construct(
        public bool $success
    ) { }
}
