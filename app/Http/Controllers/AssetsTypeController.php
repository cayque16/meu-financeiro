<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Models\AssetsType;
use Illuminate\Http\Request;

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
        $dados['titulo'] = 'Adicionar';
        $dados['action'] = '/assets_type';

        return view('assets_types.create_edit', $dados);
    }

    public function store(Request $request)
    {
        $assetsType = new AssetsType();

        $assetsType->nome = $request->nome;
        $assetsType->descricao = $request->descricao;

        $assetsType->save();

        return redirect('/assets_type')->with('msg', 'Tipo de ativo criado com sucesso!');
    }

    public function edit($id)
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: '/assets_type');
        $dados['assetsType'] = AssetsType::findOrFail($id);
        $dados['titulo'] = 'Editar';
        $dados['action'] = "/assets_type/update/$id";

        return view('assets_types.create_edit', $dados);
    }

    public function update(Request $request)
    {
        AssetsType::findOrFail($request->id)->update($request->all());

        return redirect('/assets_type')->with('msg', 'Tipo de ativo editado com sucesso!');
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
                getBtnLink(ButtonType::EDITAR, "/assets_type/edit/$dado->id"),
                getBtnLink(ButtonType::EXCLUIR),
            ];
        }
        return $data;
    }
}