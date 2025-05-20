<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreAssetsTypeRequest;
use App\Models\AssetsType;

class AssetsTypeControllerOld extends MyControllerAbstract
{
    public function __construct()
    {
        $this->setTextoMsg('Tipo de ativo');
        parent::__construct((new AssetsType()), 'assets_type');
    }

    public function store(StoreAssetsTypeRequest $request)
    {
        return $this->superStore($request);
    }

    public function update(StoreAssetsTypeRequest $request)
    {
        return $this->superUpdate($request);
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
        foreach($dados as $dado) {
            $botao = $dado->e_excluido ? ButtonType::ATIVAR : ButtonType::DESATIVAR;
            $eExcluido = $dado->e_excluido ? Status::ATIVADO : Status::DESATIVADO;
            $data[] = [
                $dado->id, 
                $dado->nome,
                $dado->descricao,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/assets_type/edit/$dado->id")."  ".getBtnLink($botao, "/assets_type/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }
}