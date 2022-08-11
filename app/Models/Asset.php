<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function assetsType()
    {
        return $this->belongsTo(AssetsType::class, 'id_assets_type', 'id');
    }
}
