<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Http\Requests\StoreDividendPaymentRequest;
use Core\Domain\Presentation\AssetPresentationInterface;
use Core\Domain\Enum\DividendType;
use Core\Domain\Presentation\CurrencyPresentationInterface;
use Core\Domain\Presentation\DividendPaymentPresentationInterface;
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
use Illuminate\Http\Request;

class DividendsController extends Controller
{
    public function index(
        ListDividendsPaymentUseCase $useCase,
        DividendPaymentPresentationInterface $dividendPresentation,
        ListAssetsUseCase $useCaseAssets,
        AssetPresentationInterface $assetPresentation,
        Request $request,
    ) {
        $response = $useCase->execute(new ListDividendsPaymentInputDto());
        $assets = $useCaseAssets->execute(new ListAssetsInputDto(includeInactive: false));
        $data["cabecalho"] = $this->getHead();
        $data["tabela"] = ['data' => $this->getTable($response)];
        $data["btnAdd"] = getBtnLink(ButtonType::INCLUDE, link: "dividends/create");
        $data["paymentYear"] = $dividendPresentation->yearsOfPayment($response->items);
        $data["fiscalYears"] = $dividendPresentation->fiscalYears($response->items);
        $data["assets"] = $assetPresentation->arrayToSelect($assets->items);
        $data["types"] = $dividendPresentation->typesToArray();
        
        return view("dividends.index", $data);
    }

    public function filterIndex(
        ListDividendsPaymentUseCase $useCase,
        DividendPaymentPresentationInterface $dividendPresentation,
        ListAssetsUseCase $useCaseAssets,
        AssetPresentationInterface $assetPresentation,
        Request $request,
    ) {
        $response = $useCase->execute(new ListDividendsPaymentInputDto(
            paymentYear: $request->input('payment_year'),
            fiscalYear: $request->input('fiscal_year'),
            idAsset: $request->input('asset_id'),
            idType: $request->input('type'),
        ));
        $assets = $useCaseAssets->execute(new ListAssetsInputDto(includeInactive: false));
        $data["cabecalho"] = $this->getHead();
        $data["tabela"] = ['data' => $this->getTable($response)];
        $data["btnAdd"] = getBtnLink(ButtonType::INCLUDE, link: "dividends/create");
        $data["paymentYear"] = $dividendPresentation->yearsOfPayment($response->items);
        $data["fiscalYears"] = $dividendPresentation->fiscalYears($response->items);
        $data["assets"] = $assetPresentation->arrayToSelect($assets->items);
        $data["types"] = $dividendPresentation->typesToArray();
        
        return view("dividends.index", $data);
    }

    public function create(
        ListCurrenciesUseCase $useCaseCurrencies,
        ListAssetsUseCase $useCaseAssets,
        AssetPresentationInterface $assetPresentation,
        CurrencyPresentationInterface $currencyPresentation,
        DividendPaymentPresentationInterface $dividendPresentation,
    ) {
        $currencies = $useCaseCurrencies->execute(new ListCurrenciesInputDto(includeInactive: false));
        $assets = $useCaseAssets->execute(new ListAssetsInputDto(includeInactive: false));
        
        $data['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/dividends");
        $data['titulo'] = 'Adicionar';
        $data['action'] = "/dividends";
        $data["currencies"] = $currencyPresentation->arrayToSelect($currencies->items);
        $data["assets"] = $assetPresentation->arrayToSelect($assets->items);
        $data["years"] = $this->getSelectYears();
        $data["types"] = $dividendPresentation->typesToArray();

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
