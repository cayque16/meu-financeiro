<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Operation;

abstract class MyControllerAbstract extends Controller
{
    protected $withKey;

    protected $withValue;

    protected $modelBase;

    protected $viewBase;

    protected $dados;

    protected $textoMsg;

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

        $this->dados['cabecalho'] = $this->getCabecalho();

        $this->dados['tabela'] = ['data' => $this->getTabela($allDados)];

        $this->dados['btnAdd'] = getBtnLink(ButtonType::INCLUDE, link: "$this->viewBase/create");

        return view("$this->viewBase.index", $this->dados);
    }

    public function create()
    {
        $this->dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/$this->viewBase");
        $this->dados['titulo'] = 'Adicionar';
        $this->dados['action'] = "/$this->viewBase";

        return view("$this->viewBase.create_edit", $this->dados);
    }

    public function superStore($request)
    {
        $retorno = $this->modelBase->insert($request);

        $this->trataRetorno($retorno, Operation::CREATE);

        return redirect("/$this->viewBase")->with($this->withKey, $this->withValue);
    }

    public function superUpdate($request)
    {
        $retorno = $this->modelBase
            ->getFindOrFail($request->id)
            ->update($request->all());
        
        $this->trataRetorno($retorno, Operation::EDIT);

        return redirect("/$this->viewBase")->with($this->withKey, $this->withValue);
    }

    protected function trataRetorno($retorno, $Operation)
    {
        $acao = $Operation == Operation::EDIT 
            ? Operation::EDITED 
            : Operation::CREATED;
            
        list($this->withKey, $this->withValue) = $retorno ? 
            ['msg', $this->getTextoMsg()." $acao com sucesso!"] : 
            ['erro', "Houve um erro ao $Operation o ".$this->getTextoMsg()];
    }

    public function edit($id)
    {
        $this->dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/".$this->viewBase);
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
         
        $this->trataRetorno($retorno, Operation::EDIT);

        return redirect("/".$this->viewBase)->with($this->withKey, $this->withValue);
    }

    protected function setDados($indice, $valor)
    {
        $this->dados[$indice] = $valor;
    }

    protected function getTextoMsg()
    {
        return $this->textoMsg;
    }

    protected function setTextoMsg($textoMsg)
    {
        $this->textoMsg = $textoMsg;
    }
}
