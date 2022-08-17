<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreAssetRequest;
use App\Models\AssetsType;

class AssetsController extends MyControllerAbstract
{
    private $assetsType;

    public function __construct()
    {
        $this->setTextoMsg('Ativo');
        parent::__construct((new Asset), 'assets');
        $this->assetsType = new AssetsType();
    }

    public function create()
    {
        $this->setDados(
            'assetsType',
            $this->getArraySelectAssetsType()
        );

        return parent::create();
    }

    public function edit($id)
    {
        $this->setDados(
            'assetsType', 
            $this->getArraySelectAssetsType()
        );
        return parent::edit($id);
    }

    public function store(StoreAssetRequest $request)
    {
        return $this->superStore($request);
    }

    public function update(StoreAssetRequest $request)
    {
        return $this->superUpdate($request);
    }

    protected function getCabecalho()
    {
        return [
            'Id',
            'Código',
            'Descricao',
            'Tipo de Ativo',
            'Data Criação',
            'Data Atualização',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }

    protected function getTabela($dados)
    {
        $data = [];
        foreach($dados as $dado) {
            $botao = $dado->e_excluido ?  ButtonType::ATIVAR : ButtonType::DESATIVAR;
            $eExcluido = $dado->e_excluido ? Status::ATIVADO : Status::DESATIVADO;
            $data[] = [
                $dado->id, 
                $dado->codigo,
                $dado->descricao,
                $dado->assetsType->nome,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/assets/edit/$dado->id")."  ".getBtnLink($botao, "/assets/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }

    private function getArraySelectAssetsType()
    {
        return array_column($this->assetsType->sltAssetsTypes(), 'nome', 'id');
    }
}
