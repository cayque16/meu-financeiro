<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brokerage extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'web_page',
        'cnpj',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sltBrokerages($arrayStatus = [Status::ACTIVE])
    {
        $result = Brokerage::select('id', 'nome')
            ->whereIn('e_excluido', $arrayStatus)
            ->orderBy('nome')
            ->get()
            ->toArray();

        return array_column($result, 'nome', 'id');
    }
}
