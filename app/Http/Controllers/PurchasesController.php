<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Asset;
use App\Models\Brokerage;
use App\Enums\ButtonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\AssetPurchase;
use App\Enums\Operacao;
use App\Enums\TabelaReferencia;
use App\Models\ControlFile;
use Exception;

class PurchasesController extends MyControllerAbstract
{
    private static $TAXA_TOTAL = 'taxaTotal';
    private static $TOTAL_NOTA = 'totalNota';
    private static $ATIVO_ID = 'ativoId';
    private static $ATIVO_NOME = 'ativoNome';
    private static $PRECO = 'preco';
    private static $QUANTIDADE = 'quantidade';
    private static $ARRAY_DADOS = 'arrayDados';

    private static $KEY_RESPOSTA = 'sucesso';
    private static $KEY_MSG = 'msg';


    public function __construct()
    {
        $this->setTextoMsg('Compra');
        parent::__construct((new Purchase), 'purchases');
        $this->assets = new Asset();
        $this->brokerages = new Brokerage();
    }

    public function create()
    {
        $this->setDados(
            'assets',
            $this->assets->sltAssets()
        );

        $this->setDados(
            'brokerages',
            $this->brokerages->sltBrokerages()
        );

        return parent::create();
    }

    public function store(StorePurchaseRequest $request)
    {
        try {
            $purchase = $this->modelBase::create([
                'data' => formataDataBd($request->input('data')),
                'id_brokerages' => $request->input('id_brokerages')
            ]);
            
            $taxaTotal = Session::get(self::$TAXA_TOTAL);
            $arrayDados = unserialize(Session::get(self::$ARRAY_DADOS));
            $totalNota = Session::get(self::$TOTAL_NOTA);
            
            foreach($arrayDados as $ativo) {
                $taxaAtivo = $this->getTaxaAtivo($ativo[2], $ativo[3], $totalNota, $taxaTotal);
                $retorno = AssetPurchase::create([
                    'purchase_id' => $purchase->id, 
                    'asset_id' => $ativo[0], 
                    'quantidade' => $ativo[3], 
                    'valor_unitario' => $ativo[2], 
                    'taxas' => $taxaAtivo
                ]);
                if(!$retorno) break;
            }

            if($retorno && $request->hasFile('notaCorretagem') && $request->file('notaCorretagem')->isValid()) {
                $requestFile = $request->notaCorretagem;
                $extensao = $requestFile->extension();
                $fileName = hashNomeDeArquivos($requestFile->getClientOriginalName(), $purchase->id, TabelaReferencia::PURCHASES);
                
                $retorno = ControlFile::create([
                    'id_referencia' => $purchase->id,
                    'id_table_references' => TabelaReferencia::PURCHASES, 
                    'nome_original' => $requestFile->getClientOriginalName(), 
                    'extensao' => $extensao
                ]);

                if($retorno) {
                    $requestFile->move(public_path('arquivos/notas'), $fileName);
                }
            }
            
            $this->trataRetorno($retorno, Operacao::CRIAR);

            return redirect("/$this->viewBase")->with($this->withKey, $this->withValue);
        } catch (Exception $erro) {
            var_dump("Aconteceu um erro: ".$erro);
        } finally {
            Session::forget([
                self::$TOTAL_NOTA,
                self::$ARRAY_DADOS,
                self::$TAXA_TOTAL
            ]);
        }
    }

    public function show($id)
    {
        $this->setDados('btnVoltar', getBtnLink(ButtonType::VOLTAR, link: "/$this->viewBase"));

        $tabela = (new AssetPurchase)->lstAtivosPorIdCompra($id);
        $valorTotal = 0;
        $dataCompra = '';
        array_walk($tabela, function(&$dado) use (&$valorTotal, &$dataCompra) {
            $total = $dado['quantidade'] * $dado['valor_unitario'] + $dado['taxas'];
            $valorTotal += $total;
            $dado['total'] = formata_moeda($total);
            $dado['valor_unitario'] = formata_moeda($dado['valor_unitario']);
            $dado['taxas'] = formata_moeda($dado['taxas']);
            $dataCompra = formataDataBr($dado['data'], false);
        });
        $this->setDados('dataCompra', $dataCompra);
        $this->setDados('valorTotal', formata_moeda($valorTotal));
        $this->setDados('arrayTabela', $tabela);
        
        return view("$this->viewBase.show", $this->dados);
    }

    public function adicionaAtivos(Request $request)
    {
        $validacao = $this->validaEntrada($request);
        if(!$validacao[self::$KEY_RESPOSTA]) {
            return $validacao;
        }
        
        Session::put(self::$TAXA_TOTAL, $request->input(self::$TAXA_TOTAL));

        if(Session::has(self::$TOTAL_NOTA)) {
            $totalNota = Session::get(self::$TOTAL_NOTA);
            $totalNota += $request->input(self::$PRECO) * $request->input(self::$QUANTIDADE);
            Session::put(self::$TOTAL_NOTA, $totalNota);
        } else {
            Session::put(self::$TOTAL_NOTA, $request->input(self::$PRECO) * $request->input(self::$QUANTIDADE));
        }

        $dadosRequest = $this->getDadosRequest($request);
        $idArray = getUniqId();
        if(Session::has(self::$ARRAY_DADOS)) {
            $arrayDados = unserialize(Session::get(self::$ARRAY_DADOS));
            $arrayDados[$idArray] = $dadosRequest;
            Session::put(self::$ARRAY_DADOS, serialize($arrayDados));
        } else {
            $arrayDados[$idArray] = $dadosRequest;
            Session::put(self::$ARRAY_DADOS, serialize($arrayDados));
        }

        $taxaTotal = Session::get(self::$TAXA_TOTAL);
        $dados = unserialize(Session::get(self::$ARRAY_DADOS));
        
        $retorno[self::$KEY_MSG] = '';
        $totalNota = Session::get(self::$TOTAL_NOTA);
        foreach($dados as $chave => $dado) {
            $taxaAtivo = $this->getTaxaAtivo($dado[2], $dado[3], $totalNota, $taxaTotal);
            $retorno[self::$KEY_MSG] .= "
            <tr>
                <td>".$dado[1]."</td>
                <td>".formata_moeda($dado[2])."</td>
                <td>".$dado[3]."</td>
                <td>".formata_moeda($taxaAtivo)."</td>
                <td>".formata_moeda(($dado[2]*$dado[3])+$taxaAtivo)."</td>
                <td><button type='button' class='btn btn-danger' onclick='removeAtivo(\"$chave\")'><i class='fas fa-trash'></i></button></td>
            </tr>";
        }
        $retorno[self::$KEY_RESPOSTA] = true;
        return json_encode($retorno);
    }

    public function removeAtivos(Request $request)
    {
        $idArray = $request->input('idArray');
        $arrayDados = unserialize(Session::get(self::$ARRAY_DADOS));

        $totalNota = Session::get(self::$TOTAL_NOTA);
        $totalNota -= $arrayDados[$idArray][2] * $arrayDados[$idArray][3];
        Session::put(self::$TOTAL_NOTA, $totalNota);

        unset($arrayDados[$idArray]);
        Session::put(self::$ARRAY_DADOS, serialize($arrayDados));

        $taxaTotal = Session::get(self::$TAXA_TOTAL);
        $dados = unserialize(Session::get(self::$ARRAY_DADOS));
        
        $retorno[self::$KEY_MSG] = '';
        $totalNota = Session::get(self::$TOTAL_NOTA);
        foreach($dados as $dado) {
            $taxaAtivo = $this->getTaxaAtivo($dado[2], $dado[3], $totalNota, $taxaTotal);
            $retorno[self::$KEY_MSG] .= "
            <tr>
                <td>".$dado[1]."</td>
                <td>".formata_moeda($dado[2])."</td>
                <td>".$dado[3]."</td>
                <td>".formata_moeda($taxaAtivo)."</td>
                <td>".formata_moeda(($dado[2]*$dado[3])+$taxaAtivo)."</td>
                <td><button type='button' class='btn btn-danger' onclick='removeAtivo(\"$idArray\")'><i class='fas fa-trash'></i></button></td>
            </tr>";
        }
        $retorno[self::$KEY_RESPOSTA] = true;
        return json_encode($retorno);
    }

    private function getTaxaAtivo($preco, $quantidade, $totalNota, $taxaTotal)
    {
        $total = $preco * $quantidade;
        return round(($total/$totalNota)*$taxaTotal, 2);
    }

    private function validaEntrada($request)
    {
        $retorno[self::$KEY_RESPOSTA] = true;
        if(is_null($request->input(self::$TAXA_TOTAL))) {
            $validar[] = 'Total Taxas';
        }    
        if($request->input(self::$ATIVO_ID) == 0) {
            $validar[] = 'Ativo';
        }
        if(empty($request->input(self::$PRECO))) {
            $validar[] = 'Preço';
        }
        if(empty($request->input(self::$QUANTIDADE))) {
            $validar[] = 'Quantidade';
        } 
        
        if(isset($validar)) {
            $retorno[self::$KEY_RESPOSTA] = false;
            $retorno[self::$KEY_MSG] = '<ul>';
            foreach($validar as $regra) {
                $retorno[self::$KEY_MSG] .= "<li>O campo $regra é obrigatório.</li>";
            }
            $retorno[self::$KEY_MSG] .= '</ul>';
        }

        return $retorno;
    }

    private function getDadosRequest($request)
    {
        return [
            $request->input(self::$ATIVO_ID),
            $request->input(self::$ATIVO_NOME),
            $request->input(self::$PRECO),
            $request->input(self::$QUANTIDADE),
        ];    
    }
    
    protected function getCabecalho()
    {
        return [
            'Id',
            'Data',
            'Data Criação',
            'Data Atualização',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }

    protected function getTabela($dados)
    {
        $data = [];
        foreach($dados as $dado) {
            $data[] = [
                $dado->id, 
                formataDataBr($dado->data, false),
                formataDataBr($dado->created_at),
                formataDataBr($dado->updated_at),
                getBtnLink(ButtonType::EXIBIR, "/purchases/show/$dado->id")
            ];
        }
        return $data;
    }
}
