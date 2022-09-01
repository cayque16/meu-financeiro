<?php

namespace App\Models;

use App\Enums\TabelaReferencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
                    ->where('id_table_references', '=', TabelaReferencia::PURCHASES);
            })
            ->where('purchase_id', '=', $idCompra)
            ->get()
            ->toArray();
    }
}
