<?php

namespace Core\Domain\Presentation;

interface DividendPaymentPresentationInterface extends BasePresentationInterface
{
    public function typesToArray(): array;
}
