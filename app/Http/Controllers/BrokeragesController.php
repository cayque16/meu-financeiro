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
        $this->setTextoMsg('Corretora');
        parent::__construct((new Brokerage()), 'brokerages');
    }

    public function store(StoreBrokerageRequest $request)
    {
        return $this->superStore($request);
    }

    public function update(StoreBrokerageRequest $request)
    {
        return $this->superUpdate($request);
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
