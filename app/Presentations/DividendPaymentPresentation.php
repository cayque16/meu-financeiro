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

    public function yearsOfPayment(array $items): array
    {
        $result = [];
        foreach ($items as $payment) {
            $result[$payment->paymentDate->getYear()] = $payment->paymentDate->getYear();
        }
        return $result;
    }

    public function fiscalYears(array $items): array
    {
        $result = [];
        foreach ($items as $payment) {
            $result[$payment->fiscalYear] = $payment->fiscalYear;
        }
        return $result;
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
