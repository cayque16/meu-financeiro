<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use Core\UseCase\AssetType\ListAssetsTypesUseCase;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;
use Illuminate\Http\Request;

class AssetsTypeController extends Controller
{
    public function index(Request $request, ListAssetsTypesUseCase $useCase)
    {
        $allDados = $useCase->execute(new ListAssetsTypesInputDto());
        
        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allDados)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUDE, link: "assets_type/create");

        return view("assets_type.index", $dados);
    }

    protected function getCabecalho()
    {
        return  [
            'Id',
            'Nome',
            'Descricao',
            'Data Criação',
            'Data Atualização',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }

    protected function getTabela($dados)
    {
        $data = [];
        foreach($dados->items as $dado) {
            // $botao = $dado->e_excluido ? ButtonType::ACTIVATE : ButtonType::DISABLE;
            $botao = ButtonType::ACTIVATE;
            // $eExcluido = $dado->e_excluido ? Status::ACTIVE : Status::INACTIVE;
            $eExcluido = Status::ACTIVE;
            $data[] = [
                $dado->id, 
                $dado->name,
                $dado->description,
                $dado->createdAt,
                $dado->updatedAt,
                "<nobr>".getBtnLink(ButtonType::EDIT, "/assets_type/edit/$dado->id")."  ".getBtnLink($botao, "/assets_type/enable/$dado->id/0")."</nobr>"
            ];
        }
        return $data;
    }
}
