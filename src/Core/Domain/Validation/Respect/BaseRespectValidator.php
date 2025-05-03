<?php

namespace Core\Domain\Validation\Respect;

use Core\Domain\Validation\EntityValidatorInterface;
use Respect\Validation\Exceptions\NestedValidationException;

abstract class BaseRespectValidator implements EntityValidatorInterface
{
    protected $errors = [];

    public function createValidations(array $data, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert(isset($data[$field]) ? $data[$field] : null);
            } catch (NestedValidationException $e) {
                $this->errors[] = $e->getMessages();
            }
        }
    }

    public function failed(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
