<?php

namespace Core\Domain\Validation\Factories;

use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\Validation\Respect\BrokerageRespectValidator;

class BrokerageValidatorFactory
{
    public static function create(): EntityValidatorInterface
    {
        return new BrokerageRespectValidator();
    }
}
