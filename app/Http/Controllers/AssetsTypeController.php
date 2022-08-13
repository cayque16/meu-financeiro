<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreAssetsTypeRequest;
use App\Models\AssetsType;

class AssetsTypeController extends MyControllerAbstract
{
    private $assetsType;

    public function __construct()
    {
        parent::__construct((new AssetsType()), 'assets_type');
    }

    public function store(StoreAssetsTypeRequest $request)
    {
        $retorno = $this->modelBase->insert($request);

        $this->trataRetorno($retorno, Operacao::CRIAR);

        return redirect('/assets_type')->with($this->key, $this->value);
    }

    public function update(StoreAssetsTypeRequest $request)
    {
        $retorno = $this->modelBase
            ->getFindOrFail($request->id)
            ->update($request->all());

        $this->trataRetorno($retorno, Operacao::EDITAR);

        return redirect('/assets_type')->with($this->key, $this->value);
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