<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CurrenciesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('currencies')->insert([
            [
                'id'          => (string) Str::uuid(),
                'name'        => 'Real Brasileiro',
                'symbol'      => 'R$',
                'iso_code'    => 'BRL',
                'split'       => 100,
                'decimals'    => 2,
                'description' => 'Moeda oficial do Brasil',
                'created_at'  => $now,
                'updated_at'  => $now,
                'deleted_at'  => null,
            ],
            [
                'id'          => (string) Str::uuid(),
                'name'        => 'Bitcoin',
                'symbol'      => '₿',
                'iso_code'    => 'BTC',
                'split'       => 100000000, // satoshis por bitcoin
                'decimals'    => 8,
                'description' => 'Criptomoeda descentralizada',
                'created_at'  => $now,
                'updated_at'  => $now,
                'deleted_at'  => null,
            ],
        ]);
    }
}
