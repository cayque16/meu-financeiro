<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use Core\UseCase\Asset\ListAssetsUseCase;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function index(ListAssetsUseCase $useCase)
    {
        $response = $useCase->execute(new ListAssetsInputDto());
        $data["cabecalho"] = $this->getHead();
        $data["tabela"] = ['data' => $this->getTable($response)];
        $data["btnAdd"] = getBtnLink(ButtonType::INCLUDE, link: "assets/create");

        return view("assets.index", $data);
    }

    private function getTable($data)
    {
        $result = [];
        foreach($data->items as $item) {
            // dd($item);
            $button = $item->isActive() ? ButtonType::DISABLE : ButtonType::ACTIVATE;
            $action = $item->isActive() ? Status::ACTIVE : Status::INACTIVE;
            $result[] = [
                $item->id,
                $item->code,
                $item->description,
                $item->type->name,
                $item->createdAt()?->toDateBr(true),
                $item->updatedAt()?->toDateBr(true),
                $item->deletedAt()?->toDateBr(true) ?? "-",
                "<nobr>".getBtnLink(ButtonType::EDIT, "/assets/edit/$item->id")."  ".getBtnLink($button, "/assets/enable/$item->id/$action")."</nobr>",
            ];
        }

        return $result;
    }

    private function getHead()
    {
        return [
            'Id',
            'Código',
            'Descricao',
            'Tipo de Ativo',
            'Data Criação',
            'Data Atualização',
            'Data Desativação',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }
}
