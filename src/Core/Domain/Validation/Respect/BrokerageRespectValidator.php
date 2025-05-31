<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator as v;

class BrokerageRespectValidator extends BaseRespectValidator
{
    public function validate(BaseEntity $baseEntity): bool
    {
        $this->createValidations([
            'name' => $baseEntity->name,
            'webPage' => $baseEntity->webPage,
        ], [
            'name' => v::stringType()->length(3, 150),
            'webPage' => v::url(),
        ]);

        return $this->failed();
    }
}
