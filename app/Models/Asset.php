<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'code',
        'description',
        'assets_type_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'string',
        'assets_type_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getAll()
    {
        return self::all();
    }

    // public function sltAssets($arrayStatus = [Status::ACTIVE])
    // {
    //     $result = Asset::select('id', 'codigo')
    //         ->whereIn('e_excluido', $arrayStatus)
    //         ->orderBy('codigo')
    //         ->get()
    //         ->toArray();

    //     return array_column($result, 'codigo', 'id');
    // }

    public function assetsType()
    {
        return $this->hasOne(AssetsType::class, 'id', 'assets_type_id')
            ->withTrashed();
    }
}
