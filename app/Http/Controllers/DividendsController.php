<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Http\Requests\StoreDividendPaymentRequest;
use Core\Domain\Enum\DividendType;
use Core\Domain\ValueObject\Date;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Asset\ListAssetsUseCase;
use Core\UseCase\Currency\ListCurrenciesUseCase;
use Core\UseCase\DividendPayment\CreateDividendPaymentUseCase;
use Core\UseCase\DividendPayment\ListDividendsPaymentUseCase;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Core\UseCase\DTO\Currency\ListCurrencies\ListCurrenciesInputDto;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\ListDividendsPayment\ListDividendsPaymentInputDto;

class DividendsController extends Controller
{
    public function index(ListDividendsPaymentUseCase $useCase)
    {
        $response = $useCase->execute(new ListDividendsPaymentInputDto());
        
        $data["cabecalho"] = $this->getHead();
        $data["tabela"] = ['data' => $this->getTable($response)];
        $data["btnAdd"] = getBtnLink(ButtonType::INCLUDE, link: "dividends/create");

        return view("dividends.index", $data);
    }

    public function create(
        ListCurrenciesUseCase $useCaseCurrencies,
        ListAssetsUseCase $useCaseAssets
    ) {
        $currencies = $useCaseCurrencies->execute(new ListCurrenciesInputDto(includeInactive: false));
        $assets = $useCaseAssets->execute(new ListAssetsInputDto(includeInactive: false));
        
        $data['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/dividends");
        $data['titulo'] = 'Adicionar';
        $data['action'] = "/dividends";
        $data["currencies"] = $this->entitiesToSelect($currencies->items);
        $data["assets"] = $this->entitiesToSelect($assets->items, value: "code");
        $data["years"] = $this->getSelectYears();
        $data["types"] = $this->getTypes();

        return view("dividends.create_edit", $data);
    }

    public function store(
        StoreDividendPaymentRequest $request,
        CreateDividendPaymentUseCase $useCase
    ) {
        $useCase->execute(
            new CreateDividendPaymentInputDto(
                idAsset: $request->id_asset,
                paymentDate: new Date($request->payment_date),
                fiscalYear: $request->fiscal_year,
                type: DividendType::from($request->type),
                amount: $request->amount,
                idCurrency: $request->id_currency,
            )
        );
        return redirect("/dividends")->with("msg", "Dividendo inserido com sucesso!");
    }

    private function getTypes()
    {
        $types = [];
        foreach(DividendType::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }

    private function getSelectYears()
    {
        $currentYear = (new Date())->getYear();
        $minYear = $currentYear - 10;
        $maxYear = $currentYear + 10;
        
        $years = [];
        for($i = $minYear; $i <= $maxYear; $i++ ) {
            $years[$i] = $i;
        }

        return $years;
    }

    private function entitiesToSelect($types, $id = 'id', $value = 'name')
    {
        $result = [];
        foreach ($types as $type) {
            $result[$type->$id()] = $type->$value;
        }
        return $result;
    }

    private function getTable($data)
    {
        $result = [];
        foreach($data->items as $item) {
            $result[] = [
                Uuid::short($item->id),
                $item->paymentDate?->toDateBr(),
                $item->fiscalYear,
                $item->asset->code,
                $item->type->value,
                $item->getAmountFormatted(),
            ];
        }

        return  $result;
    }

    private function getHead()
    {
        return [
            'Id',
            'Data',
            'Ano Fiscal',
            'Ativo',
            'Tipo',
            'Valor',
        ];
    }
}
