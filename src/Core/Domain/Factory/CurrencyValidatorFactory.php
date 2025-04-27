<?php

namespace Core\Domain\Factory;

use Core\Domain\Validation\CurrencyLaravelValidator;
use Core\Domain\Validation\CurrentRespectValidator;
use Core\Domain\Validation\ValidatorInterface;

class CurrencyValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new CurrentRespectValidator();
    }
}
