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
        Schema::dropIfExists("assets_types");

        Schema::rename("assets_type_tmp", "assets_type");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename( "assets_type", "assets_type_tmp");

        Schema::create('assets_types', function (Blueprint $table) {
            $table->id();
            $table->char('nome', 30);
            $table->char('descricao', 150)->nullable();
            $table->boolean('e_excluido')->default(0);
            $table->timestamps();
        });
    }
};
