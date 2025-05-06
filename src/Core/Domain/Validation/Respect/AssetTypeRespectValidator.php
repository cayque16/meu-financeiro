<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Entity\BaseEntity;
use Respect\Validation\Validator as v;

class AssetTypeRespectValidator extends BaseRespectValidator
{
    public function validate(BaseEntity $baseEntity): bool
    {
        $this->createValidations([
            'name' => $baseEntity->name,
            'description' => $baseEntity->description
        ], [
            'name' => v::stringType()->length(3, 30),
            'description' => v::optional(v::stringType()->length(max: 150)),
        ]);

        return $this->failed();
    }
}
