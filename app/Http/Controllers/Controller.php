<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Enums\ButtonType;
use App\Enums\Operacao;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
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

    abstract protected function getCabecalho();

    abstract protected function getTabela($dados);

    public function index()
    {
        $allDados = $this->modelBase->getAll();

        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allDados)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUIR, link: "$this->viewBase/create");

        return view("$this->viewBase.index", $dados);
    }

    public function create()
    {
        $this->dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: "/$this->viewBase");
        $this->dados['titulo'] = 'Adicionar';
        $this->dados['action'] = "/$this->viewBase";

        return view("$this->viewBase.create_edit", $this->dados);
    }

    protected function trataRetorno($retorno, $operacao)
    {
        $acao = $operacao == Operacao::EDITAR 
            ? Operacao::EDITADOS 
            : Operacao::CRIADOS;
            
        list($this->key, $this->value) = $retorno ? 
            ['msg', "Dados $acao com sucesso!"] : 
            ['erro', "Houve um erro ao $operacao os dados!"];
    }

    public function edit($id)
    {
        $this->dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: "/".$this->viewBase);
        $this->dados['modelBase'] = $this->modelBase->getFindOrFail($id);
        $this->dados['titulo'] = 'Editar';
        $this->dados['action'] = "/$this->viewBase/update/$id";

        return view("$this->viewBase.create_edit", $this->dados);
    }

    public function enable($id, $eExcluido)
    {
        $retorno = $this->modelBase
            ->getFindOrFail($id)
            ->update(['e_excluido' => $eExcluido]);
         
        $this->trataRetorno($retorno, Operacao::EDITAR);

        return redirect("/".$this->viewBase)->with($this->key, $this->value);
    }

    protected function setDados($indice, $valor)
    {
        $this->dados[$indice] = $valor;
    }
}
