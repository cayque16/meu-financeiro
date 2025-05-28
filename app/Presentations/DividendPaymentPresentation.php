<?php

namespace App\Presentations;

use Core\Domain\Enum\DividendType;
use Core\Domain\Presentation\DividendPaymentPresentationInterface;
use Core\UseCase\Exceptions\NotImplementedException;

class DividendPaymentPresentation implements DividendPaymentPresentationInterface
{
    public function arrayToSelect(array $items): array
    {
        throw new NotImplementedException('This method has not been implemented!');
    }

    public function typesToArray(): array
    {
        $types = [];
        foreach(DividendType::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }
}
