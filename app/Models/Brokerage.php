<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brokerage extends MyModelAbstract
{
    protected $fillable = ['nome', 'site', 'cnpj', 'e_excluido'];

    use HasFactory;

    public function __construct()
    {
        parent::__construct($this);
    }

    public function sltBrokerages($arrayStatus = [Status::ATIVADO])
    {
        $result = Brokerage::select('id', 'nome')
            ->whereIn('e_excluido', $arrayStatus)
            ->orderBy('nome')
            ->get()
            ->toArray();

        return array_column($result, 'nome', 'id');
    }
}
