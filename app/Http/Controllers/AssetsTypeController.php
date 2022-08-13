<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreAssetsTypeRequest;
use App\Models\AssetsType;

class AssetsTypeController extends Controller
{
    private $assetsType;

    public function __construct()
    {
        parent::__construct((new AssetsType()), 'assets_type');
        $this->assetsType = new AssetsType();
    }

    public function index()
    {
        $allAssetsType = $this->assetsType->getAll();
        
        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allAssetsType)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUIR, link: 'assets_type/create');

        return view('assets_type.index', $dados);
    }

    public function create()
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: '/assets_type');
        $dados['titulo'] = 'Adicionar';
        $dados['action'] = '/assets_type';

        return view('assets_type.create_edit', $dados);
    }

    public function store(StoreAssetsTypeRequest $request)
    {
        $retorno = $this->assetsType->insert($request);

        $this->trataRetorno($retorno, Operacao::CRIAR);

        return redirect('/assets_type')->with($this->key, $this->value);
    }

    public function update(StoreAssetsTypeRequest $request)
    {
        $retorno = $this->assetsType
            ->getFindOrFail($request->id)
            ->update($request->all());

        $this->trataRetorno($retorno, Operacao::EDITAR);

        return redirect('/assets_type')->with($this->key, $this->value);
    }

    public function enable($id, $eExcluido)
    {
        $this->assetsType->getFindOrFail($id)->update(['e_excluido' => $eExcluido]);

        $msg = $eExcluido ? 'desativado' : 'ativado';

        return redirect('/assets_type')->with('msg', "Tipo de ativo $msg com sucesso!");
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
            $botao = $dado->e_excluido ? ButtonType::ATIVAR : ButtonType::DESATIVAR;
            $eExcluido = $dado->e_excluido ? Status::ATIVADO : Status::DESATIVADO;
            $data[] = [
                $dado->id, 
                $dado->nome,
                $dado->descricao,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/assets_type/edit/$dado->id")."  ".getBtnLink($botao, "/assets_type/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }
}