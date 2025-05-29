<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MyModelAbstract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetsType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'uuid',
        'nome',
        'descricao',
        'e_excluido',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'uuid'=> 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function assets()
    {
        return $this->belongsTo(Asset::class, 'uuid_assets_type', 'uuid')
            ->withTrashed();
    }
}
