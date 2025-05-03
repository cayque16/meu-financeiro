<?php

namespace Core\Domain\Validation\Factories;

use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\Validation\Respect\CurrencyRespectValidator;

class CurrencyValidatorFactory
{
    public static function create(): EntityValidatorInterface
    {
        return new CurrencyRespectValidator();
    }
}
