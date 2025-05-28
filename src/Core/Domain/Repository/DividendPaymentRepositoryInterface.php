<?php

namespace Core\Domain\Repository;

interface DividendPaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function lstDividends(
        ?int $paymentYear = null,
        ?int $fiscalYear = null,
        ?string $idAsset = null,
        ?string $idType = null
    ): array;

    public function lstYearsOfPayment(): array;

    public function lstFiscalYears(): array;
}
