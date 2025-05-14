<?php

namespace Core\Domain\Repository;

interface DividendPaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function lstDividends(
        ?int $ano = null,
        ?string $idAsset = null,
        ?int $idType = null
    ): array;
}
