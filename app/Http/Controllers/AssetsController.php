<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Enums\ButtonType;
use App\Enums\Status;

class AssetsController extends Controller
{
    public function index()
    {
        $allAssets = Asset::all();
        
        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allAssets)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUIR, link: 'assets/create');

        return view('assets.index', $dados);
    }

    private function getCabecalho()
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

    private function getTabela($dados)
    {
        $data = [];
        foreach($dados as $dado) {
            $botao = !$dado->e_excluido ? ButtonType::DESATIVAR : ButtonType::ATIVAR;
            $eExcluido = !$dado->e_excluido ? Status::ATIVADO : Status::DESATIVADO;
            $data[] = [
                $dado->id, 
                $dado->codigo,
                $dado->descricao,
                $dado->assetsType->nome,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/assets/edit/$dado->id")."  ".getBtnLink($botao, "/assets/enable/$dado->id/$eExcluido")."</nobr>"
            ];
            // dd(!$dado->e_excluido);
        }
        return $data;
    }
}
