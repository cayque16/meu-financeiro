<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DividendPayment extends Model
{
    use HasFactory, SoftDeletes;

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

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }
}
