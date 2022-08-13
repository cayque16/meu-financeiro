<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Enums\ButtonType;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $key;

    protected $value;

    protected $modelBase;

    protected $viewBase;

    public function __construct($modelBase, $viewBase)
    {
        $this->modelBase = $modelBase;
        $this->viewBase = $viewBase;
    }

    protected function trataRetornoInsert($retorno)
    {
        list($this->key, $this->value) = $retorno ? 
            ['msg', 'Ativo criado com sucesso!'] : 
            ['erro', 'Houve um erro ao inserir o ativo!'];
    }

    public function edit($id)
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: "/".$this->viewBase);
        $dados['assetsType'] = $this->modelBase->getFindOrFail($id);
        $dados['titulo'] = 'Editar';
        $dados['action'] = "/$this->viewBase/update/$id";

        return view("$this->viewBase.create_edit", $dados);
    }
}
