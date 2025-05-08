<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator as v;

class AssetRespectValidator extends BaseRespectValidator
{
    public function validate(BaseEntity $baseEntity): bool
    {
        $this->createValidations([
            'code' => $baseEntity->code,
            'description' => $baseEntity->description,
        ], [
            'code' => v::stringType()->length(3, 10),
            'description' => v::optional(v::stringType()->length(max: 100)),
        ]);
        
        return $this->failed();
    }
}
