<?php

namespace App\Http\Controllers;

use App\Models\AssetsType;

class AssetsTypeController extends Controller
{
    public function index()
    {
        $teste = AssetsType::all();
        $data = [];
        foreach($teste as $dado) {
            $data[] = [
                $dado->id, 
                $dado->nome,
                $dado->descricao,
                $dado->created_at,
                $dado->updated_at,
                $this->getBtn(1),
                $this->getBtn(2),
            ];
        }
        
        $dados['heads'] = [
            'Id',
            'Nome',
            'Descricao',
            'Data Criação',
            'Data Atualização',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];

        $dados['config'] = [
            'data' => $data
        ];

        return view('assets_types.index', $dados);
    }

    private function getBtn($tipo = null, $id = null)
    {
        $teste = [
            1 => ['text' => 'text-primary', 'msg' => 'Editar', 'icon' => 'pen'],
            2 => ['text' => 'text-danger', 'msg' => 'Excluir', 'icon' => 'trash'],
        ];
        
        $button = '<button class="btn btn-xs btn-default %s mx-1 shadow" title="%s">
                <i class="fa fa-lg fa-fw fa-%s"></i>
            </button>';
            // var_dump(printf($button, $teste[1]['text'], $teste[1]['msg'], $teste[1]['icon']));
        return sprintf($button, $teste[$tipo]['text'], $teste[$tipo]['msg'], $teste[$tipo]['icon']);
    }
}