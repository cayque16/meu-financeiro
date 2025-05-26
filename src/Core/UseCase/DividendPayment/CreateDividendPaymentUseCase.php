<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Entity\DividendPayment;
use Core\Domain\Repository\AssetRepositoryInterface;
use Core\Domain\Repository\CurrencyRepositoryInterface;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class CreateDividendPaymentUseCase
{
    public function __construct(
        protected DividendPaymentRepositoryInterface $repoDividendPayment,
        protected AssetRepositoryInterface $repoAsset,
        protected CurrencyRepositoryInterface $repoCurrency,
    ) { }

    public function execute(CreateDividendPaymentInputDto $input): CreateDividendPaymentOutputDto
    {
        $asset = $this->repoAsset->findById($input->idAsset)
            ?? throw new NotFoundException("No asset with that id was found: {$input->idAsset}");
        $currency = $this->repoCurrency->findById($input->idCurrency)
            ?? throw new NotFoundException("No currency with that id was found: {$input->idCurrency}");

        $dividend = new DividendPayment(
            asset: $asset,
            paymentDate: $input->paymentDate,
            fiscalYear: $input->fiscalYear,
            type: $input->type,
            amount: $input->amount * $currency->split,
            currency: $currency,
        );

        $return = $this->repoDividendPayment->insert($dividend);

        return new CreateDividendPaymentOutputDto(
            id: $return->id(),
            idAsset: $return->asset->id(),
            paymentDate: $return->paymentDate,
            fiscalYear: $input->fiscalYear,
            type: $return->type,
            amount: $return->amount,
            idCurrency: $return->currency->id(),
            isActive: $return->isActive(),
            createdAt: $return->createdAt(),
            updatedAt: $return->updatedAt(),
            deletedAt: $return->deletedAt(),
        );
    }
}
