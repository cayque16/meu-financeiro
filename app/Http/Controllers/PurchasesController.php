<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Enums\ButtonType;
use App\Enums\Status;

class PurchasesController extends MyControllerAbstract
{
    public function __construct()
    {
        parent::__construct((new Purchase), 'purchases');
    }
    
    protected function getCabecalho()
    {
        return [
            'Id',
            'Data',
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
                formataDataBr($dado->data, false),
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/purchases/edit/$dado->id")."  ".getBtnLink($botao, "/purchases/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }
}
