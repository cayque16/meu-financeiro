<?php

namespace Database\Seeders;

use App\Models\AssetsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MakeUuidAssetsType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetsType::whereNull('uuid')->chunk(100, function ($types) {
            foreach ($types as $type) {
                $type->uuid = Str::uuid();
                $type->save();
            }
        });
    }
}
