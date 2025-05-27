<?php

namespace Core\Domain\Presentation;

interface DividendPaymentPresentationInterface extends BasePresentationInterface
{
    public function yearsOfPayment(array $items): array;

    public function fiscalYears(array $items): array;

    public function typesToArray(): array;
}
