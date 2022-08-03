<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Models\AssetsType;

class AssetsTypeController extends Controller
{
    public function index()
    {
        $allAssetsType = AssetsType::all();
        
        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allAssetsType)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUIR, link: 'assets_type/create');

        return view('assets_types.index', $dados);
    }

    public function create()
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: '/assets_type');

        return view('assets_types.create_edit', $dados);
    }

    private function getCabecalho()
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

    private function getTabela($dados)
    {
        $data = [];
        foreach($dados as $dado) {
            $data[] = [
                $dado->id, 
                $dado->nome,
                $dado->descricao,
                $dado->created_at,
                $dado->updated_at,
                getBtnLink(ButtonType::EDITAR),
                getBtnLink(ButtonType::EXCLUIR),
            ];
        }
        return $data;
    }
}