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
            $button = $item->isActive() ? ButtonType::DISABLE : ButtonType::ACTIVATE;
            $action = $item->isActive() ? Status::ACTIVE : Status::INACTIVE;
            $result[] = [
                $item->id,
                $item->date?->toDateBr(),
                $item->asset->code,
                $item->type->value,
                $item->getAmountFormatted(),
                "<nobr>".getBtnLink(ButtonType::EDIT, "/assets/edit/$item->id")."  ".getBtnLink($button, "/assets/enable/$item->id/$action")."</nobr>",
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
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }
}
