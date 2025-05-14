<?php

namespace Core\Domain\Validation\Factories;

use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\Validation\Respect\DividendPaymentRespectValidator;

class DividendPaymentValidatorFactory
{
    public static function create(): EntityValidatorInterface
    {
        return new DividendPaymentRespectValidator();
    }
}
