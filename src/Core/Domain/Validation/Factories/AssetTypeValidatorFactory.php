<?php

namespace Core\Domain\Validation\Factories;

use Core\Domain\Validation\EntityValidatorInterface;
use Core\Domain\Validation\Respect\AssetTypeRespectValidator;

class AssetTypeValidatorFactory
{
    public static function create(): EntityValidatorInterface
    {
        return new AssetTypeRespectValidator();
    }
}
