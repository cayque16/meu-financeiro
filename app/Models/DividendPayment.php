<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DividendPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "dividends_payments";

    protected $fillable = [
        'id',
        'asset_id',
        'date',
        'type',
        'amount',
        'currency_id',
        'deleted_at',
        'created_at',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'asset_id' => 'string',
        'currency_id' => 'string',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'uuid', 'asset_id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
