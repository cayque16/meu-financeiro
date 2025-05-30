<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('asset_purchase');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('asset_purchase', function (Blueprint $table) {
            $table->foreignId('purchase_id')->constrained();
            $table->foreignId('asset_id')->constrained();
            $table->integer('quantidade');
            $table->decimal('valor_unitario');
            $table->decimal('taxas')->default(0);
            $table->boolean('e_excluido')->default(0);
            $table->timestamps();
        });
    }
};
