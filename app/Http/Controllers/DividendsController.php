<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use Core\UseCase\DividendPayment\ListDividendsPaymentUseCase;
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

    private function getTable($data)
    {
        $result = [];
        foreach($data->items as $item) {
            $result[] = [
                $item->id,
                $item->date?->toDateBr(),
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
            'Ativo',
            'Tipo',
            'Valor',
        ];
    }
}
