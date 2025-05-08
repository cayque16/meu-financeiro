<?php

namespace Core\Domain\Validation\Factories;

use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\Validation\Respect\AssetRespectValidator;

class AssetValidatorFactory
{
    public static function create(): EntityValidatorInterface
    {
        return new AssetRespectValidator();
    }
}
