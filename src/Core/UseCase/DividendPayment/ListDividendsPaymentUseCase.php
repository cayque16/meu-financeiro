<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentOutputDto;

class ListDividendsPaymentUseCase
{
    public function __construct(
        protected DividendPaymentRepositoryInterface $repository
    ) { }

    public function execute(ListDividendsPaymentInputDto $input): ListDividendsPaymentOutputDto
    {
        $result = $this->repository->lstDividends(
            paymentYear: $input->paymentYear,
            fiscalYear: $input->fiscalYear,
            idAsset: $input->idAsset,
            idType: $input->idType,
        );

        return new ListDividendsPaymentOutputDto(items: $result);
    }
}
