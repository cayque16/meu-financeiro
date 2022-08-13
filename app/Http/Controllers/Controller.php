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

    protected $dados;

    public function __construct($modelBase, $viewBase)
    {
        $this->modelBase = $modelBase;
        $this->viewBase = $viewBase;
        $this->dados = [];
    }

    protected function trataRetornoInsert($retorno)
    {
        list($this->key, $this->value) = $retorno ? 
            ['msg', 'Ativo criado com sucesso!'] : 
            ['erro', 'Houve um erro ao inserir o ativo!'];
    }

    public function edit($id)
    {
        $this->dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: "/".$this->viewBase);
        $this->dados['modelBase'] = $this->modelBase->getFindOrFail($id);
        $this->dados['titulo'] = 'Editar';
        $this->dados['action'] = "/$this->viewBase/update/$id";

        return view("$this->viewBase.create_edit", $this->dados);
    }

    protected function setDados($indice, $valor)
    {
        $this->dados[$indice] = $valor;
    }
}
