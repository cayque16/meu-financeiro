<?php

namespace Core\UseCase\DividendPayment;

use Core\Domain\Entity\DividendPayment;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentOutputDto;
use Core\UseCase\Exceptions\NotFoundException;

class CreateDividendPaymentUseCase
{
    public function __construct(
        protected DividendPaymentRepositoryInterface $repoDividendPayment,
        protected BaseRepositoryInterface $repoAsset,
        protected BaseRepositoryInterface $repoCurrency,
    ) { }

    public function execute(CreateDividendPaymentInputDto $input): CreateDividendPaymentOutputDto
    {
        $asset = $this->repoAsset->findById($input->idAsset)
            ?? throw new NotFoundException("No asset with that id was found: {$input->idAsset}");
        $currency = $this->repoCurrency->findById($input->idCurrency)
            ?? throw new NotFoundException("No currency with that id was found: {$input->idCurrency}");

        $dividend = new DividendPayment(
            asset: $asset,
            date: new Date($input->date),
            type: $input->type,
            amount: $input->amount,
            currency: $currency,
        );

        $return = $this->repoDividendPayment->insert($dividend);

        return new CreateDividendPaymentOutputDto(
            id: $return->id(),
            idAsset: $return->asset->id(),
            date: $return->date,
            type: $return->type,
            amount: $return->amount,
            idCurrency: $return->currency->id(),
            // isActive: $return->isActive(),
            createdAt: $return->createdAt,
        );
    }
}
