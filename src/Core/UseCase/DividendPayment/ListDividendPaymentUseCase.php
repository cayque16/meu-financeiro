<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Repository\BaseRepositoryInterface;
use Core\UseCase\DTO\DividendPayment\DividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\DividendPaymentOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class ListDividendPaymentUseCase
{
    public function __construct(
        protected BaseRepositoryInterface $repository
    ) { }

    public function execute(DividendPaymentInputDto $input): DividendPaymentOutputDto
    {
        $payment = $this->repository->findById($input->id)
            ?? throw new NotFoundException("No dividend payment with that id was found: {$input->id}");

        return new DividendPaymentOutputDto(
            id: $payment->id(),
            idAsset: $payment->asset->id(),
            date: $payment->date,
            type: $payment->type,
            amount: $payment->amount,
            idCurrency: $payment->currency->id(),
            isActive: $payment->isActive(),
            createdAt: $payment->createdAt()
        );
    }
}
