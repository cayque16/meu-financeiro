<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator as v;

class CurrencyRespectValidator extends BaseRespectValidator
{
    public function validate(BaseEntity $baseEntity): bool
    {
        $this->createValidations([
            'name' => $baseEntity->name,
            'symbol' => $baseEntity->symbol,
            'isoCode' => $baseEntity->isoCode,
            'split' => $baseEntity->split,
            'description' => $baseEntity->description,
        ], [
            'name' => v::stringType()->length(3, 25),
            'symbol' => v::stringType()->length(1, 5),
            'isoCode' => v::stringType()->length(3),
            'split' => v::intVal()->min(0),
            'description' => v::stringType()->length(3, 100),
        ]);

        return $this->failed();
    }
}
