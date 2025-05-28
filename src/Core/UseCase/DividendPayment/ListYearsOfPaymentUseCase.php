<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Date;

class ListYearsOfPaymentUseCase
{
    public function __construct(
        protected DividendPaymentRepositoryInterface $repository,
    ) { }

    public function execute(): array
    {
        $result = $this->repository->lstYearsOfPayment();
        $years = [];
        foreach ($result as $row) {
            $year = (new Date($row['payment_date']))->getYear();
            $years[$year] = $year;
        }
        
        return $years;
    }
}
