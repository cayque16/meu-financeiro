<?php

namespace App\Models;

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

}
