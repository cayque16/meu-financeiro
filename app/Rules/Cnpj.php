<?php

namespace App\Rules;

use Core\Domain\ValueObject\Cnpj as ValueObjectCnpj;
use Illuminate\Contracts\Validation\InvokableRule;

class Cnpj implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!ValueObjectCnpj::isValidCnpj($value)) {
            $fail('validation.cnpj')->translate();
        }
    }
}
