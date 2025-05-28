<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Repository\DividendPaymentRepositoryInterface;

class ListFiscalYearsUseCase
{
    public function __construct(
        protected DividendPaymentRepositoryInterface $repository,
    ) { }

    public function execute(): array
    {
        $result = $this->repository->lstFiscalYears();
        $years = [];
        foreach ($result as $row) {
            $year = $row['fiscal_year'];
            $years[$year] = $year;
        }
        
        return $years;
    }
}
