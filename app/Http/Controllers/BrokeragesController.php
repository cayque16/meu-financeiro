<?php

namespace App\Http\Controllers;

use App\Models\Brokerage;
use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreBrokerageRequest;

class BrokeragesController extends MyControllerAbstract
{
    public function __construct()
    {
        parent::__construct((new Brokerage()), 'brokerages');
    }

    public function store(StoreBrokerageRequest $request)
    {
        $retorno = $this->modelBase->insert($request);

        $this->trataRetorno($retorno, Operacao::CRIAR);

        return redirect('/brokerages')->with($this->key, $this->value);
    }

    public function update(StoreBrokerageRequest $request)
    {
        $retorno = $this->modelBase
            ->getFindOrFail($request->id)
            ->update($request->all());
        
        $this->trataRetorno($retorno, Operacao::EDITAR);

        return redirect('/brokerages')->with($this->key, $this->value);
    }
    
    protected function getCabecalho()
    {
        return [
            'Id',
            'Nome',
            'Site',
            'CNPJ',
            'Data Criação',
            'Data Atualização',
            ['label' => 'Ações', 'no-export' => true, 'width' => 5]
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
                $dado->nome,
                $dado->site,
                $dado->cnpj,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/brokerages/edit/$dado->id")."  ".getBtnLink($botao, "/brokerages/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }
}
