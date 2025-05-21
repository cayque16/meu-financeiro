<?php

namespace App\Models;

use App\Enums\ReferenceTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class AssetPurchase extends MyModelAbstract
{
    use HasFactory;

    protected $table = 'asset_purchase';

    protected $fillable = ['purchase_id', 'asset_id', 'quantidade', 'valor_unitario', 'taxas'];

    public function __construct()
    {
        parent::__construct($this);
    }

    public function lstAtivosPorIdCompra($idCompra)
    {
        return AssetPurchase::select('purchases.data','assets.codigo', 'quantidade', 'valor_unitario', 'taxas', 'nome_original')
            ->join('assets', 'asset_id', '=', 'assets.id')
            ->join('purchases', 'purchase_id', '=', 'purchases.id')
            ->leftJoin('control_files', function ($leftJoin){
                $leftJoin->on('purchase_id', '=', 'id_referencia')
                    ->where('id_table_references', '=', ReferenceTable::PURCHASES);
            })
            ->where('purchase_id', '=', $idCompra)
            ->get()
            ->toArray();
    }

    public function sqlCalculaTotalInvestidoPorAno($ano = 0)
    {
        $query = AssetPurchase::select(
                'a.codigo', 
                DB::raw('SUM(quantidade) as qtde'), 
                DB::raw('SUM(valor_unitario * quantidade + taxas) as total'),
                DB::raw('MIN(valor_unitario) as valor_min'),
                DB::raw('MAX(valor_unitario) as valor_max')
            )
            ->join('assets as a', 'asset_id', '=', 'a.id')
            ->join('purchases as p', 'purchase_id', '=', 'p.id')
            ->groupBy('a.id')
            ->orderBy('a.codigo');

        if($ano) {
            $query->whereYear('p.data', $ano);
        }
        
        $retorno = $query->get()->toArray();

        array_walk($retorno, function(&$dado) {
            $dado['media'] = $dado['total'] / $dado['qtde'];
        });

        return $retorno;
    }
}
