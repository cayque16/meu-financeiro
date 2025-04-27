<?php

namespace Core\Domain\Validation;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator;

class CurrentRespectValidator implements ValidatorInterface
{
    public function validate(BaseEntity $entity): array
    {
        $errors = [];
        $entityValidator = Validator::attribute('name', Validator::stringType()->length(3, 25));
        if (!$entityValidator->isValid($entity)) {
            $errors[] = "Invalid name: the field must have at least 3 and a maximum of 25 characters\n";
        }

        $entityValidator = Validator::attribute('symbol', Validator::stringType()->length(1, 5));
        if (!$entityValidator->isValid($entity)) {
            $errors[] = "Invalid symbol: the field must have at least 1 and a maximum of 5 characters\n";
        }

        $entityValidator = Validator::attribute('isoCode', Validator::stringType()->length(3, 5));
        if (!$entityValidator->isValid($entity)) {
            $errors[] = "Invalid isoCode: the field must have at least 3 and a maximum of 5 characters\n";
        }

        $entityValidator = Validator::attribute('description', Validator::stringType()->length(3, 100));
        if (!$entityValidator->isValid($entity)) {
            $errors[] = "Invalid description: the field must have at least 3 and a maximum of 100 characters\n";
        }

        return $errors;
    }
}
