<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Enums\ButtonType;
use App\Enums\Operacao;
use App\Enums\Status;
use App\Http\Requests\StoreAssetRequest;
use App\Models\AssetsType;

class AssetsController extends Controller
{

    private $asset;

    private $assetsType;

    public function __construct()
    {
        parent::__construct((new Asset), 'assets');
        $this->asset = new Asset();
        $this->assetsType = new AssetsType();
    }

    public function index()
    {
        $allAssets = $this->asset->getAll();
        
        $dados['cabecalho'] = $this->getCabecalho();

        $dados['tabela'] = ['data' => $this->getTabela($allAssets)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUIR, link: 'assets/create');

        return view('assets.index', $dados);
    }

    public function create()
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::VOLTAR, link: '/assets');
        $dados['titulo'] = 'Adicionar';
        $dados['action'] = '/assets';
        $dados['assetsType'] = array_column($this->assetsType->sltAssetsTypes(), 'nome', 'id');

        return view('assets.create_edit', $dados);
    }

    public function edit($id)
    {
        $this->setDados('assetsType', array_column($this->assetsType->sltAssetsTypes(), 'nome', 'id'));
        return parent::edit($id);
    }

    public function store(StoreAssetRequest $request)
    {
        $retorno = $this->asset->insert($request);

        $this->trataRetorno($retorno, Operacao::CRIAR);

        return redirect('/assets')->with($this->key, $this->value);
    }

    public function update(StoreAssetRequest $request)
    {
        $retorno = $this->modelBase
            ->getFindOrFail($request->id)
            ->update($request->all());

        $this->trataRetorno($retorno, Operacao::EDITAR);

        return redirect('/assets')->with($this->key, $this->value);
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
            $botao = $dado->e_excluido ?  ButtonType::ATIVAR : ButtonType::DESATIVAR;
            $eExcluido = $dado->e_excluido ? Status::ATIVADO : Status::DESATIVADO;
            $data[] = [
                $dado->id, 
                $dado->codigo,
                $dado->descricao,
                $dado->assetsType->nome,
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                "<nobr>".getBtnLink(ButtonType::EDITAR, "/assets/edit/$dado->id")."  ".getBtnLink($botao, "/assets/enable/$dado->id/$eExcluido")."</nobr>"
            ];
        }
        return $data;
    }
}
