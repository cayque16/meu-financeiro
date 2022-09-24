<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetPurchase;
use App\Models\Purchase;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $dados['ano'] = $request->input('ano');

        $dadosTabela = (new AssetPurchase())->sqlCalculaTotalInvestidoPorAno($dados['ano']);
        $dados['cabecalho'] = $this->getCabecalho();
        $dados['tabela'] = ['data' => $this->getTabela($dadosTabela)];

        $totalInvestido = array_sum(array_column($dadosTabela, 'total'));
        $anoFiltroLabel = $dados['ano'] ?: "Todos";
        $dados['labelFiltro'] = "Período: $anoFiltroLabel - ".formata_moeda($totalInvestido);

        $dados['slAnos'] = (new Purchase())->sqlListaOsAnosDeCompras();

        return view('home', $dados);
    }

    private function getCabecalho()
    {
        return [
            'Ativo',
            'Qtde Total',
            'Total Investido',
            'Preço Médio',
            'Min',
            'Max'
        ];
    }

    private function getTabela($dadosTabela)
    {
        $data = [];
        foreach($dadosTabela as $dado) {
            $data[] = [
                $dado['codigo'],
                $dado['qtde'],
                formata_moeda($dado['total']),
                formata_moeda($dado['valor_min']),
                formata_moeda($dado['valor_max']),
                formata_moeda($dado['media']),
            ];
        }

        return $data;
    }
}
