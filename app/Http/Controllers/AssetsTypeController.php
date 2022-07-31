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
                getBtn(1),
                getBtn(2),
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
}