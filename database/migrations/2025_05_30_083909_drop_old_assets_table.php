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
        Schema::dropIfExists('assets');

        Schema::rename('assets_tmp', 'assets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('assets', 'assets_tmp');

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->char('codigo', 10);
            $table->char('descricao', 100)->nullable();
            $table->foreignId('id_assets_type')->constrained('assets_types');
            $table->boolean('e_excluido')->default(0);
            $table->timestamps();
        });
    }
};
