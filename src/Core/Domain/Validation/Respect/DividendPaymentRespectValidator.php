<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator as v;

class DividendPaymentRespectValidator extends BaseRespectValidator
{
    public function validate(BaseEntity $baseEntity): bool
    {
        $this->createValidations([
            'amount' => $baseEntity->amount,
        ], [
            'amount' => v::intVal()->min(1),
        ]);

        return $this->failed();
    }
}
