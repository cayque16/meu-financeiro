<?php

namespace Core\Domain\Repository;

interface DividendPaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function lstDividends(
        ?int $ano = null,
        ?string $idAsset = null,
        ?string $idType = null
    ): array;
}
