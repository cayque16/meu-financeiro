<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('name', 25);
            $table->char('symbol', 5);
            $table->char('iso_code', 3);
            $table->integer('split');
            $table->integer('decimals')->default(2);
            $table->char('description', 100);
            $table->softDeletes();
            $table->timestamps();
        });

        $now = now();

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
